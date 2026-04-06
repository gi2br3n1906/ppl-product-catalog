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
        $product1 = Product::updateOrCreate([
            'name' => 'Buku Tulis Spiral A5'
        ], [
            'name' => 'Buku Tulis Spiral A5',
            'description' => 'Buku tulis spiral untuk keperluan kuliah/ sekolah',
            'price' => 12000,
            'stock' => 150,
            'category' => 'Alat Tulis',
        ]);
        \App\Models\ProductImage::updateOrCreate(['product_id' => $product1->id], [
            'product_id' => $product1->id,
            'image_path' => 'https://loremflickr.com/640/480/stationery?random=' . rand(),
            'is_primary' => true,
        ]);

        $product2 = Product::updateOrCreate([
            'name' => 'Pulpen Hitam 0.5mm'
        ], [
            'name' => 'Pulpen Hitam 0.5mm',
            'description' => 'Pulpen stabilo, tinta hitam gel smooth',
            'price' => 8000,
            'stock' => 200,
            'category' => 'Alat Tulis',
        ]);
        \App\Models\ProductImage::updateOrCreate(['product_id' => $product2->id], [
            'product_id' => $product2->id,
            'image_path' => 'https://loremflickr.com/640/480/pen?random=' . rand(),
            'is_primary' => true,
        ]);

        $product3 = Product::updateOrCreate([
            'name' => 'Pensil 2B (Pack 12)'
        ], [
            'name' => 'Pensil 2B (Pack 12)',
            'description' => 'Pensil 2B pack 12, kualitas bagus',
            'price' => 22000,
            'stock' => 100,
            'category' => 'Alat Tulis',
        ]);
        \App\Models\ProductImage::updateOrCreate(['product_id' => $product3->id], [
            'product_id' => $product3->id,
            'image_path' => 'https://loremflickr.com/640/480/pencil?random=' . rand(),
            'is_primary' => true,
        ]);

        $product4 = Product::updateOrCreate([
            'name' => 'Sepatu New Balance'
        ], [
            'name' => 'Sepatu New Balance',
            'description' => 'Sepatu lari New Balance, nyaman dan stylish.',
            'price' => 750000,
            'stock' => 50,
            'category' => 'Fashion',
        ]);
        \App\Models\ProductImage::updateOrCreate(['product_id' => $product4->id], [
            'product_id' => $product4->id,
            'image_path' => 'https://loremflickr.com/640/480/new_balance_shoes?random=' . rand(),
            'is_primary' => true,
        ]);

        $product5 = Product::updateOrCreate([
            'name' => 'AC Daikin'
        ], [
            'name' => 'AC Daikin',
            'description' => 'Air conditioner Daikin 1 PK, dingin dan hemat energi.',
            'price' => 3500000,
            'stock' => 20,
            'category' => 'Elektronik',
        ]);
        \App\Models\ProductImage::updateOrCreate(['product_id' => $product5->id], [
            'product_id' => $product5->id,
            'image_path' => 'https://loremflickr.com/640/480/air_conditioner?random=' . rand(),
            'is_primary' => true,
        ]);

        $product6 = Product::updateOrCreate([
            'name' => 'Lemari Kaca'
        ], [
            'name' => 'Lemari Kaca',
            'description' => 'Lemari pajangan dengan pintu kaca.',
            'price' => 1200000,
            'stock' => 15,
            'category' => 'Furnitur',
        ]);
        \App\Models\ProductImage::updateOrCreate(['product_id' => $product6->id], [
            'product_id' => $product6->id,
            'image_path' => 'https://loremflickr.com/640/480/glass_cabinet?random=' . rand(),
            'is_primary' => true,
        ]);

        $product7 = Product::updateOrCreate([
            'name' => 'HP Xiaomi 17 Pro Max'
        ], [
            'name' => 'HP Xiaomi 17 Pro Max',
            'description' => 'Smartphone Xiaomi dengan kamera 200MP dan layar AMOLED.',
            'price' => 8000000,
            'stock' => 30,
            'category' => 'Elektronik',
        ]);
        \App\Models\ProductImage::updateOrCreate(['product_id' => $product7->id], [
            'product_id' => $product7->id,
            'image_path' => 'https://www.mobiledokan.com/media/xiaomi-17-pro-max-purple-official-image.webp',
            'is_primary' => true,
        ]);

        $product8 = Product::updateOrCreate([
            'name' => 'Lenovo Yoga Slim 7i'
        ], [
            'name' => 'Lenovo Yoga Slim 7i',
            'description' => 'Laptop tipis dan ringan dengan prosesor Intel Core i7.',
            'price' => 15000000,
            'stock' => 25,
            'category' => 'Elektronik',
        ]);
        \App\Models\ProductImage::updateOrCreate(['product_id' => $product8->id], [
            'product_id' => $product8->id,
            'image_path' => 'https://p3-ofp.static.pub/fes/cms/2024/11/21/gqcdxq3sua3gef6ms67xxktgdgep56977541.png',
            'is_primary' => true,
        ]);
    }
}
