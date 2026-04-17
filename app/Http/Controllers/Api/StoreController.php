<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\JsonResponse;

class StoreController extends Controller
{
    public function index(): JsonResponse
    {
        $stores = Store::query()->orderBy('name')->get();

        return response()->json([
            'data' => $stores,
        ]);
    }

    public function show(Store $store): JsonResponse
    {
        return response()->json([
            'data' => $store,
        ]);
    }
}
