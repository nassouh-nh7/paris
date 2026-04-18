<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Listing;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ListingController extends Controller
{
    private const MAX_LISTING_IMAGE_BYTES = 10 * 1024 * 1024;

    private const ALLOWED_LISTING_IMAGE_MIME_TYPES = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/webp' => 'webp',
        'image/heic' => 'heic',
        'image/heif' => 'heif',
    ];

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
        $validated['network_image_urls'] = $this->buildNetworkImageUrls($validated);
        $validated['local_image_paths'] = [];
        $validated['rental_blocked_dates'] = [];
        $validated['id'] = $validated['id'] ?? Str::uuid()->toString();

        $listing = Listing::query()->create($validated);

        return response()->json([
            'data' => $listing,
        ], 201);
    }

    public function update(Request $request, Listing $listing): JsonResponse
    {
        $validated = $this->validateListing($request, true);
        $existingImageUrls = is_array($listing->network_image_urls) ? $listing->network_image_urls : [];
        $baseImageUrls = $request->exists('network_image_urls')
            ? ($validated['network_image_urls'] ?? [])
            : $existingImageUrls;

        $incomingImageUrls = $this->buildNetworkImageUrls($validated, $baseImageUrls);

        if ($request->exists('network_image_urls') || $request->exists('listing_images')) {
            $validated['network_image_urls'] = $incomingImageUrls;
        }

        if ($request->exists('local_image_paths')) {
            $validated['local_image_paths'] = [];
        }

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
            'network_image_urls' => ['sometimes', 'array'],
            'network_image_urls.*' => ['required', 'string', 'max:2000'],
            'listing_images' => ['sometimes', 'array'],
            'listing_images.*.filename' => ['required_with:listing_images', 'string', 'max:255'],
            'listing_images.*.mime_type' => ['required_with:listing_images', 'string', 'max:100'],
            'listing_images.*.content_base64' => ['required_with:listing_images', 'string'],
            'local_image_paths' => ['sometimes', 'array'],
            'local_image_paths.*' => ['required', 'string', 'max:2000'],
            'rental_blocked_dates' => ['nullable', 'array'],
            'rental_blocked_dates.*' => ['nullable', 'date'],
            'status' => ['nullable', 'string', 'max:50'],
            'is_rented_out' => ['nullable', 'boolean'],
            'is_sold' => ['nullable', 'boolean'],
            'created_at' => ['nullable', 'date'],
            'updated_at' => ['nullable', 'date'],
        ]);
    }

    private function buildNetworkImageUrls(array &$validated, array $baseImageUrls = []): array
    {
        $networkImageUrls = $validated['network_image_urls'] ?? $baseImageUrls;
        $listingImages = $validated['listing_images'] ?? [];

        foreach ($listingImages as $index => $image) {
            $binary = base64_decode($image['content_base64'] ?? '', true);

            if ($binary === false) {
                throw ValidationException::withMessages([
                    "listing_images.$index.content_base64" => 'Invalid base64 image payload.',
                ]);
            }

            if (strlen($binary) > self::MAX_LISTING_IMAGE_BYTES) {
                throw ValidationException::withMessages([
                    "listing_images.$index.content_base64" => 'Image exceeds the maximum allowed size.',
                ]);
            }

            $mimeType = strtolower((string) ($image['mime_type'] ?? ''));
            $extension = self::ALLOWED_LISTING_IMAGE_MIME_TYPES[$mimeType] ?? null;

            if ($extension === null) {
                throw ValidationException::withMessages([
                    "listing_images.$index.mime_type" => 'Unsupported image mime type.',
                ]);
            }

            $filenameExtension = strtolower(pathinfo((string) ($image['filename'] ?? ''), PATHINFO_EXTENSION));
            if ($filenameExtension !== '' && !in_array($filenameExtension, self::ALLOWED_LISTING_IMAGE_MIME_TYPES, true)) {
                throw ValidationException::withMessages([
                    "listing_images.$index.filename" => 'Unsupported image file extension.',
                ]);
            }

            $path = sprintf(
                'listings/%s.%s',
                Str::uuid()->toString(),
                $extension
            );

            Storage::disk('public')->put($path, $binary);
            $networkImageUrls[] = Storage::disk('public')->url($path);
        }

        unset($validated['listing_images']);

        return $networkImageUrls;
    }
}
