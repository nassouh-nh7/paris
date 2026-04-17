<?php

namespace Database\Seeders;

use App\Models\Listing;
use Illuminate\Database\Seeder;

class ListingSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Listing::query()->create([
            'id' => 'l_seed_1',
            'owner_user_id' => 'u_seed',
            'title' => 'Personal Closet Satin Dress',
            'description' => 'User listing sample for API-backed closet management.',
            'occasion' => 'party',
            'sizes' => ['S', 'M'],
            'condition' => 'excellent',
            'rent_price' => 85,
            'buy_price' => 320,
            'listing_mode' => 'both',
            'network_image_urls' => [
                'https://images.unsplash.com/photo-1595777457583-95e059d581b8?w=900&q=80',
            ],
            'local_image_paths' => [],
            'rental_blocked_dates' => [],
            'status' => 'active',
            'is_rented_out' => false,
            'is_sold' => false,
        ]);
    }
}
