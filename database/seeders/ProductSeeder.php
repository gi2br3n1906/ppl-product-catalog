<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductImage;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        $categories = [
            'Alat Tulis' => 'stationery,pen',
            'Fashion' => 'clothing,fashion',
            'Elektronik' => 'laptop,smartphone',
            'Furnitur' => 'furniture,chair',
            'Olahraga' => 'sports,fitness',
            'Makanan' => 'food,snack',
            'Kecantikan' => 'cosmetics,skincare',
            'Otomotif' => 'car,motorcycle',
            'Mainan' => 'toys,kids',
            'Kesehatan' => 'health,medicine'
        ];

        $categoryNames = array_keys($categories);

        for ($i = 1; $i <= 50; $i++) {
            $cat = $faker->randomElement($categoryNames);
            $kw = $categories[$cat];
            
            $name = ucwords(implode(' ', $faker->words(rand(2, 4)))) . " " . $i;
            
            $product = Product::updateOrCreate(
                ['name' => $name],
                [
                    'description' => $faker->paragraph(3),
                    'price' => $faker->numberBetween(10, 500) * 1000,
                    'stock' => $faker->numberBetween(5, 100),
                    'category' => $cat,
                ]
            );

            ProductImage::updateOrCreate(['product_id' => $product->id], [
                'image_path' => "https://loremflickr.com/640/480/" . urlencode($kw) . "?lock=" . $i,
                'is_primary' => true,
            ]);
        }
    }
}