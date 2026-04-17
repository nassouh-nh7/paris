<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PromoBanner;
use Illuminate\Http\JsonResponse;

class PromoBannerController extends Controller
{
    public function index(): JsonResponse
    {
        $banners = PromoBanner::query()
            ->orderBy('position')
            ->get(['id', 'image_url', 'position']);

        return response()->json([
            'data' => $banners,
        ]);
    }
}
