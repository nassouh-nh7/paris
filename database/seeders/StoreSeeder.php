<?php

namespace Database\Seeders;

use App\Models\Store;
use Illuminate\Database\Seeder;

class StoreSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $rows = [
            [
                'id' => 'st_velvet',
                'name' => 'Velvet Atelier',
                'description' => 'Editorial evening wear & couture-inspired rentals.',
                'logo_url' => 'https://images.unsplash.com/photo-1441986300917-64679bd600d8?w=200&q=80',
                'banner_url' => 'https://images.unsplash.com/photo-1445205170230-053b83016050?w=1400&q=80',
                'rating' => 4.9,
                'review_count' => 328,
                'city' => 'SoHo, NYC',
                'location' => '428 W Broadway, SoHo, New York, NY 10012',
                'contact_email' => 'concierge@velvetatelier.example',
                'contact_phone' => '+1 (212) 555-0148',
            ],
            [
                'id' => 'st_lune',
                'name' => 'Maison Lune',
                'description' => 'Minimal gowns for galas, weddings, and black-tie.',
                'logo_url' => 'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?w=200&q=80',
                'banner_url' => 'https://images.unsplash.com/photo-1469334031218-e382a71b716b?w=1400&q=80',
                'rating' => 4.8,
                'review_count' => 201,
                'city' => 'West Village',
                'location' => '88 Perry St, West Village, New York, NY 10014',
                'contact_email' => 'hello@maisonlune.example',
                'contact_phone' => '+1 (646) 555-0200',
            ],
            [
                'id' => 'st_aurora',
                'name' => 'Aurora Bridal',
                'description' => 'Statement dresses for modern brides & parties.',
                'logo_url' => 'https://images.unsplash.com/photo-1515372039744-b8f02a3cd446?w=200&q=80',
                'banner_url' => 'https://images.unsplash.com/photo-1519741497674-611481863552?w=1400&q=80',
                'rating' => 4.7,
                'review_count' => 512,
                'city' => 'Brooklyn',
                'location' => '210 Atlantic Ave, Brooklyn, NY 11201',
                'contact_email' => 'styling@aurorabridal.example',
                'contact_phone' => '+1 (718) 555-0182',
            ],
            [
                'id' => 'st_noir',
                'name' => 'Noir Closet',
                'description' => 'Rent runway looks. Buy archive pieces.',
                'logo_url' => 'https://images.unsplash.com/photo-1509631179647-0177331693ae?w=200&q=80',
                'banner_url' => 'https://images.unsplash.com/photo-1492707892479-b85f444f43d9?w=1400&q=80',
                'rating' => 4.85,
                'review_count' => 144,
                'city' => 'Online',
                'location' => 'HQ & showroom by appointment - Hudson Yards, New York, NY 10001',
                'contact_email' => 'archive@noircloset.example',
                'contact_phone' => '+1 (800) 555-0166',
            ],
        ];

        foreach ($rows as $row) {
            Store::query()->create($row);
        }
    }
}
