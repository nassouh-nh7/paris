<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Order::query()->create([
            'user_id' => 'u_seed',
            'dress_id' => 'd3',
            'dress_title' => 'Minimal Slip - Noir',
            'image_url' => 'https://images.unsplash.com/photo-1539008835657-9e8e9680c956?w=200&q=80',
            'kind' => 'rental',
            'total' => 72,
            'status' => 'confirmed',
            'rental_start' => now()->addDays(5),
            'rental_end' => now()->addDays(7),
            'placed_at' => now()->subDays(2),
        ]);
    }
}
