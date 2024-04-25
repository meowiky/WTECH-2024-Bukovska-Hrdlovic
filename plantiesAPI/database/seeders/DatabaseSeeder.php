<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $categories = [
            'Herbs', 'Cacti & Succulents', 'Indoor', 'Ornamental',
            'Edible', 'Air Purifying', 'Aquatic', 'Pet Friendly', 'Medicinal Uses'
        ];

        foreach ($categories as $category) {
            DB::table('categories')->insert([
                'name' => $category,
            ]);
        }

        $categories = DB::table('categories')->pluck('id', 'name');

        $products = [
            [
                'name' => 'Basil \'Sweet Genovese\'',
                'category_names' => ['Herbs', 'Edible', 'Medicinal Uses'],
                'price' => 5.99,
                'care_level' => 1,
                'info' => 'A popular culinary herb known for its sweet aroma and versatility in dishes.',
            ],
            [
                'name' => 'Aloe Vera',
                'category_names' => ['Medicinal Uses', 'Indoor', 'Air Purifying', 'Cacti & Succulents'],
                'price' => 12.50,
                'care_level' => 1,
                'info' => 'Widely used for skin care and burns, thrives on minimal water.',
            ],
            [
                'name' => 'Spider Plant',
                'category_names' => ['Indoor', 'Air Purifying', 'Pet Friendly'],
                'price' => 8.99,
                'care_level' => 1,
                'info' => 'Excellent at purifying indoor air; very resilient and grows quickly.',
            ],
            [
                'name' => 'Peace Lily',
                'category_names' => ['Indoor', 'Ornamental', 'Air Purifying', 'Pet Friendly'],
                'price' => 15.00,
                'care_level' => 2,
                'info' => 'Features lush leaves and white blooms; improves air quality indoors.',
            ],
            [
                'name' => 'Water Lettuce',
                'category_names' => ['Aquatic', 'Air Purifying'],
                'price' => 7.00,
                'care_level' => 2,
                'info' => 'A floating aquatic plant that purifies water and provides shade for aquatic life.',
            ],
            [
                'name' => 'Golden Pothos',
                'category_names' => ['Indoor', 'Air Purifying', 'Ornamental'],
                'price' => 10.00,
                'care_level' => 1,
                'info' => 'Hardy vine with attractive heart-shaped leaves, known for its air-purifying capabilities.',
            ],
            [
                'name' => 'Chamomile',
                'category_names' => ['Herbs', 'Medicinal Uses', 'Pet Friendly'],
                'price' => 6.50,
                'care_level' => 2,
                'info' => 'Produces daisy-like flowers and is commonly used to make calming teas.',
            ],
            [
                'name' => 'Echeveria',
                'category_names' => ['Cacti & Succulents', 'Ornamental'],
                'price' => 9.99,
                'care_level' => 1,
                'info' => 'Popular succulent with rosette patterns and minimal watering needs.',
            ],
            [
                'name' => 'Lavender',
                'category_names' => ['Herbs', 'Ornamental', 'Medicinal Uses', 'Air Purifying'],
                'price' => 14.00,
                'care_level' => 2,
                'info' => 'Renowned for its soothing fragrance and beautiful purple blooms.',
            ],
            [
                'name' => 'Snake Plant',
                'category_names' => ['Indoor', 'Air Purifying', 'Pet Friendly'],
                'price' => 20.00,
                'care_level' => 1,
                'info' => 'Thrives in low light, requires little water, and removes air toxins effectively.',
            ],
            [
                'name' => 'Mint',
                'category_names' => ['Herbs', 'Edible', 'Medicinal Uses'],
                'price' => 4.50,
                'care_level' => 1,
                'info' => 'Fast-growing herb that can be used in cooking, teas, and more.',
            ],
            [
                'name' => 'Christmas Cactus',
                'category_names' => ['Cacti & Succulents', 'Ornamental', 'Pet Friendly'],
                'price' => 12.00,
                'care_level' => 2,
                'info' => 'Blooms vibrant flowers during the holiday season, non-toxic to pets.',
            ],
        ];

        foreach ($products as $product) {
            $productId = DB::table('products')->insertGetId([
                'name' => $product['name'],
                'price' => $product['price'],
                'care_level' => $product['care_level'],
                'info' => $product['info'],
                'stock_quantity' => 100,
                'number_sold' => 0,
            ]);

            foreach ($product['category_names'] as $categoryName) {
                DB::table('product_categories')->insert([
                    'product_id' => $productId,
                    'category_id' => $categories[$categoryName],
                ]);
            }
        }
    }
}
