<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seeding a few demo products
        Product::updateOrCreate([
            'name' => 'Buku Tulis Spiral A5'
        ], [
            'name' => 'Buku Tulis Spiral A5',
            'description' => 'Buku tulis spiral untuk keperluan kuliah/ sekolah',
            'price' => 12000,
            'stock' => 150,
            'category' => 'Alat Tulis',
            'image' => 'https://loremflickr.com/640/480/stationery?random=' . rand(),
        ]);

        Product::updateOrCreate([
            'name' => 'Pulpen Hitam 0.5mm'
        ], [
            'name' => 'Pulpen Hitam 0.5mm',
            'description' => 'Pulpen stabilo, tinta hitam gel smooth',
            'price' => 8000,
            'stock' => 200,
            'category' => 'Alat Tulis',
            'image' => 'https://loremflickr.com/640/480/pen?random=' . rand(),
        ]);

        Product::updateOrCreate([
            'name' => 'Pensil 2B (Pack 12)'
        ], [
            'name' => 'Pensil 2B (Pack 12)',
            'description' => 'Pensil 2B pack 12, kualitas bagus',
            'price' => 22000,
            'stock' => 100,
            'category' => 'Alat Tulis',
            'image' => 'https://loremflickr.com/640/480/pencil?random=' . rand(),
        ]);

        Product::updateOrCreate([
            'name' => 'Sepatu New Balance'
        ], [
            'name' => 'Sepatu New Balance',
            'description' => 'Sepatu lari New Balance, nyaman dan stylish.',
            'price' => 750000,
            'stock' => 50,
            'category' => 'Fashion',
            'image' => 'https://loremflickr.com/640/480/new_balance_shoes?random=' . rand(),
        ]);

        Product::updateOrCreate([
            'name' => 'AC Daikin'
        ], [
            'name' => 'AC Daikin',
            'description' => 'Air conditioner Daikin 1 PK, dingin dan hemat energi.',
            'price' => 3500000,
            'stock' => 20,
            'category' => 'Elektronik',
            'image' => 'https://loremflickr.com/640/480/air_conditioner?random=' . rand(),
        ]);

        Product::updateOrCreate([
            'name' => 'Lemari Kaca'
        ], [
            'name' => 'Lemari Kaca',
            'description' => 'Lemari pajangan dengan pintu kaca.',
            'price' => 1200000,
            'stock' => 15,
            'category' => 'Furnitur',
            'image' => 'https://loremflickr.com/640/480/glass_cabinet?random=' . rand(),
        ]);

        Product::updateOrCreate([
            'name' => 'HP Xiaomi 17 Pro Max'
        ], [
            'name' => 'HP Xiaomi 17 Pro Max',
            'description' => 'Smartphone Xiaomi dengan kamera 200MP dan layar AMOLED.',
            'price' => 8000000,
            'stock' => 30,
            'category' => 'Elektronik',
            'image' => 'https://www.mobiledokan.com/media/xiaomi-17-pro-max-purple-official-image.webp',
        ]);

        Product::updateOrCreate([
            'name' => 'Lenovo Yoga Slim 7i'
        ], [
            'name' => 'Lenovo Yoga Slim 7i',
            'description' => 'Laptop tipis dan ringan dengan prosesor Intel Core i7.',
            'price' => 15000000,
            'stock' => 25,
            'category' => 'Elektronik',
            'image' => 'https://p3-ofp.static.pub/fes/cms/2024/11/21/gqcdxq3sua3gef6ms67xxktgdgep56977541.png',
        ]);
    }
}
