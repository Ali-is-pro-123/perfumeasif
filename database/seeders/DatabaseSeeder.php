<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate([
            'email' => 'admin@perfume.test',
        ], [
            'name' => 'Admin',
            'password' => Hash::make('admin12345'),
        ]);

        $products = [
            ['Jasmine Veil', 'jasmine-veil', 'Floral amber', 'Bestseller', 'Jasmine, bergamot, warm musk', 'Night jasmine, bergamot peel, and amber musk for a polished floral trail.', 128, '50 ml', 'assets/brand-01.jpeg', true, true, 1],
            ['Cedar Bloom', 'cedar-bloom', 'Green woods', 'New arrival', 'Violet leaf, cedar, salted fig', 'Violet leaf, salted fig, and cedarwood for fresh everyday wear.', 142, '50 ml', 'assets/brand-02.jpeg', true, true, 2],
            ['Nocturne Skin', 'nocturne-skin', 'Soft spice', 'Evening', 'Cardamom, suede, vanilla resin', 'Cardamom, suede, and vanilla resin for warm after-dark elegance.', 156, '50 ml', 'assets/brand-03.jpeg', true, true, 3],
            ['Citrus Smoke', 'citrus-smoke', 'Citrus woods', 'Fresh', 'Neroli, vetiver, tea smoke', 'Neroli, vetiver, and tea smoke for a crisp morning signature.', 136, '50 ml', 'assets/brand-04.jpeg', false, true, 4],
            ['Amber Linen', 'amber-linen', 'Soft amber', 'Clean', 'White musk, iris, clear amber', 'White musk, iris, and clear amber for soft everyday comfort.', 118, '30 ml', 'assets/brand-05.jpeg', false, true, 5],
            ['Discovery Set', 'discovery-set', 'Sample wardrobe', 'Discovery', 'Six fragrance vials', 'Six 2 ml vials with fragrance cards for testing or gifting.', 38, '6 x 2 ml', 'assets/brand-06.jpeg', false, true, 6],
        ];

        foreach ($products as $product) {
            Product::updateOrCreate([
                'slug' => $product[1],
            ], [
                'name' => $product[0],
                'category' => $product[2],
                'badge' => $product[3],
                'notes' => $product[4],
                'description' => $product[5],
                'price' => $product[6],
                'size' => $product[7],
                'image' => $product[8],
                'is_featured' => $product[9],
                'is_carousel' => $product[10],
                'sort_order' => $product[11],
            ]);
        }
    }
}
