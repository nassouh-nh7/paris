<?php

namespace Database\Seeders;

use App\Models\PromoBanner;
use Illuminate\Database\Seeder;

class PromoBannerSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $rows = [
            [
                'image_url' => 'https://images.unsplash.com/photo-1595777457583-95e059d581b8?w=1200&q=80',
                'position' => 1,
            ],
            [
                'image_url' => 'https://images.unsplash.com/photo-1539008835657-9e8e9680c956?w=1200&q=80',
                'position' => 2,
            ],
            [
                'image_url' => 'https://images.unsplash.com/photo-1566174053879-31528523f45e?w=1200&q=80',
                'position' => 3,
            ],
        ];

        foreach ($rows as $row) {
            PromoBanner::query()->create($row);
        }
    }
}
