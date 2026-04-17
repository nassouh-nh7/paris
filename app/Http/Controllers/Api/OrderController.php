<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $userId = $request->query('user_id');

        $query = Order::query()->latest('placed_at');
        if (is_string($userId) && $userId !== '') {
            $query->where('user_id', $userId);
        }

        return response()->json([
            'data' => $query->get(),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'user_id' => ['required', 'string', 'max:255'],
            'dress_id' => ['required', 'string', 'max:255'],
            'dress_title' => ['required', 'string', 'max:255'],
            'image_url' => ['required', 'string', 'max:2000'],
            'kind' => ['required', 'string', 'max:50'],
            'total' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'string', 'max:50'],
            'rental_start' => ['nullable', 'date'],
            'rental_end' => ['nullable', 'date'],
            'placed_at' => ['required', 'date'],
        ]);

        $order = Order::query()->create($validated);

        return response()->json([
            'data' => $order,
        ], 201);
    }
}
