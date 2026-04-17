<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Listing;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ListingController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $ownerUserId = $request->query('owner_user_id');
        $query = Listing::query()->latest();

        if (is_string($ownerUserId) && $ownerUserId !== '') {
            $query->where('owner_user_id', $ownerUserId);
        }

        return response()->json([
            'data' => $query->get(),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $this->validateListing($request);
        $validated['id'] = $validated['id'] ?? Str::uuid()->toString();

        $listing = Listing::query()->create($validated);

        return response()->json([
            'data' => $listing,
        ], 201);
    }

    public function update(Request $request, Listing $listing): JsonResponse
    {
        $validated = $this->validateListing($request, true);
        $listing->update($validated);

        return response()->json([
            'data' => $listing->fresh(),
        ]);
    }

    public function destroy(Listing $listing): JsonResponse
    {
        $listing->delete();

        return response()->json([
            'message' => 'Listing deleted.',
        ]);
    }

    private function validateListing(Request $request, bool $partial = false): array
    {
        $required = $partial ? ['sometimes'] : ['required'];

        return $request->validate([
            'id' => ['nullable', 'string', 'max:100'],
            'owner_user_id' => [...$required, 'string', 'max:100'],
            'title' => [...$required, 'string', 'max:255'],
            'description' => [...$required, 'string'],
            'occasion' => [...$required, 'string', 'max:50'],
            'sizes' => [...$required, 'array', 'min:1'],
            'sizes.*' => ['required', 'string', 'max:20'],
            'condition' => [...$required, 'string', 'max:50'],
            'rent_price' => [...$required, 'numeric', 'min:0'],
            'buy_price' => [...$required, 'numeric', 'min:0'],
            'listing_mode' => [...$required, 'string', 'max:50'],
            'network_image_urls' => [...$required, 'array'],
            'network_image_urls.*' => ['required', 'string', 'max:2000'],
            'local_image_paths' => [...$required, 'array'],
            'local_image_paths.*' => ['required', 'string', 'max:2000'],
            'rental_blocked_dates' => [...$required, 'array'],
            'rental_blocked_dates.*' => ['required', 'date'],
            'status' => ['nullable', 'string', 'max:50'],
            'is_rented_out' => ['nullable', 'boolean'],
            'is_sold' => ['nullable', 'boolean'],
            'created_at' => ['nullable', 'date'],
            'updated_at' => ['nullable', 'date'],
        ]);
    }
}
