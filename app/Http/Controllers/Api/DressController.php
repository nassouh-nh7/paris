<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Dress;
use App\Models\Listing;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DressController extends Controller
{
    public function index(): JsonResponse
    {
        $dresses = Dress::query()
            ->latest()
            ->get()
            ->map(static fn (Dress $dress): array => $dress->toArray());
        $listings = Listing::query()
            ->latest()
            ->get()
            ->map(fn (Listing $listing): array => $this->mapListingToDressPayload($listing));

        return response()->json([
            'data' => $dresses->merge($listings)->values(),
        ]);
    }

    private function mapListingToDressPayload(Listing $listing): array
    {
        return [
            'id' => $listing->id,
            'title' => $listing->title,
            'description' => $listing->description,
            'image_urls' => $listing->network_image_urls ?? [],
            'sizes' => $listing->sizes ?? [],
            'colors' => [],
            'occasion' => $listing->occasion,
            'condition' => $listing->condition,
            'seller_type' => 'individual',
            'rent_price' => $listing->rent_price,
            'buy_price' => $listing->buy_price,
            'listing_mode' => $listing->listing_mode,
            'store_id' => null,
            'individual_seller_name' => null,
            'seller_email' => null,
            'seller_phone' => null,
            'seller_location' => null,
            'popularity_score' => 0,
            'created_at' => $listing->created_at,
            'updated_at' => $listing->updated_at,
        ];
    }

    public function show(Dress $dress): JsonResponse
    {
        return response()->json([
            'data' => $dress,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'id' => ['nullable', 'string', 'max:50'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'image_urls' => ['required', 'array', 'min:1'],
            'image_urls.*' => ['required', 'string'],
            'sizes' => ['required', 'array', 'min:1'],
            'sizes.*' => ['required', 'string'],
            'colors' => ['required', 'array', 'min:1'],
            'colors.*' => ['required', 'string'],
            'occasion' => ['required', 'string', 'max:50'],
            'condition' => ['required', 'string', 'max:50'],
            'seller_type' => ['required', 'string', 'max:50'],
            'rent_price' => ['required', 'numeric', 'min:0'],
            'buy_price' => ['required', 'numeric', 'min:0'],
            'listing_mode' => ['required', 'string', 'max:50'],
            'store_id' => ['nullable', 'string', 'max:50'],
            'individual_seller_name' => ['nullable', 'string', 'max:255'],
            'seller_email' => ['nullable', 'email', 'max:255'],
            'seller_phone' => ['nullable', 'string', 'max:255'],
            'seller_location' => ['nullable', 'string', 'max:255'],
            'popularity_score' => ['nullable', 'integer', 'min:0'],
        ]);

        $validated['id'] = $validated['id'] ?? Str::uuid()->toString();
        $dress = Dress::query()->create($validated);

        return response()->json([
            'data' => $dress,
        ], 201);
    }
}
