<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\OtpCode;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthOtpController extends Controller
{
    public function send(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'destination' => ['required', 'email'],
        ]);

        $destination = Str::lower(trim($validated['destination']));
        $code = (string) random_int(100000, 999999);
        $expiresAt = now()->addMinutes(10);

        OtpCode::query()->create([
            'destination' => $destination,
            'code' => $code,
            'expires_at' => $expiresAt,
        ]);

        Mail::raw(
            "Your Barbie verification code is: {$code}. It expires in 10 minutes.",
            static function ($message) use ($destination): void {
                $message->to($destination)->subject('Barbie Verification Code');
            }
        );

        return response()->json([
            'message' => 'Verification code sent successfully.',
        ]);
    }

    public function verify(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'destination' => ['required', 'email'],
            'code' => ['required', 'digits:6'],
            'display_name' => ['nullable', 'string', 'max:255'],
        ]);

        $destination = Str::lower(trim($validated['destination']));

        $otp = OtpCode::query()
            ->where('destination', $destination)
            ->whereNull('used_at')
            ->latest('id')
            ->first();

        if ($otp === null) {
            return response()->json([
                'message' => 'No active code for this email. Request a new code.',
            ], 422);
        }

        if ($otp->expires_at->isPast()) {
            return response()->json([
                'message' => 'Code expired. Request a new one.',
            ], 422);
        }

        if ($otp->code !== $validated['code']) {
            return response()->json([
                'message' => 'Invalid verification code.',
            ], 422);
        }

        $otp->update(['used_at' => now()]);

        $displayName = trim((string) ($validated['display_name'] ?? ''));
        if ($displayName === '') {
            $displayName = explode('@', $destination)[0] ?? 'Member';
        }

        $user = User::query()->firstOrCreate(
            ['email' => $destination],
            [
                'name' => $displayName,
                'password' => Hash::make(Str::random(24)),
            ]
        );

        if ($user->name === '' || $user->name === null) {
            $user->name = $displayName;
            $user->save();
        }

        return response()->json([
            'data' => [
                'id' => (string) $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => null,
                'avatarUrl' => null,
                'isStoreAccount' => false,
            ],
        ]);
    }
}
