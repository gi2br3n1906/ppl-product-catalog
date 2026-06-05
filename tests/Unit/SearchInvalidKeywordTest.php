<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Controllers\ProductController;
use App\Models\User;
use App\Models\Product;
use App\Models\SellerRegistration;
use Illuminate\Http\Request;
use Illuminate\Foundation\Testing\DatabaseTransactions;


class SearchInvalidKeywordTest extends TestCase
{
    use DatabaseTransactions; // Memastikan database testing bersih setiap kali pengujian berjalan

    public function test_search_returns_empty_data_when_keyword_mismatch()
    {
        // ==========================================
        // 1. SETUP (Menyiapkan data yang tidak akan cocok)
        // ==========================================
        $seller = User::factory()->create(['role' => 'seller', 'email' => 'seller@test.com']);
        
        SellerRegistration::create([
            'email_pic' => $seller->email, 'nama_toko' => 'Toko Whitebox', 
            'deskripsi_singkat' => 'Toko keren', 'nama_pic' => 'Budi',
            'no_hp_pic' => '081234567890', 'jalan' => 'Jl. Bebas', 'rt' => '01', 'rw' => '02',
            'kelurahan' => 'Tembalang', 'kab_kota' => 'Semarang', 'provinsi' => 'Jawa Tengah',
            'no_ktp_pic' => '1234567890123456', 'foto_pic' => 'pic.jpg', 'file_ktp' => 'ktp.jpg',
            'password' => 'password123', 'status' => 'approved',
        ]);

        // Memasukkan produk "Meja Belajar"
        Product::create([
            'name' => 'Meja Belajar', 'description' => 'Meja kayu',
            'price' => 200000, 'stock' => 5, 'category' => 'Furnitur', 'seller_id' => $seller->id
        ]);

        // ==========================================
        // 2. WHITE-BOX ACTION (Panggilan Langsung dengan Query Acak)
        // ==========================================
        // Mengirim query string yang dijamin TIDAK MATCH dengan "Meja Belajar"
        $request = Request::create('/api/products/search', 'GET', ['q' => 'XYZ123RNDM']);

        $controller = new ProductController();
        $response = $controller->search($request);

        // ==========================================
        // 3. WHITE-BOX ASSERTION
        // ==========================================
        // 1. Memastikan response internal berstatus 200 OK (tidak throw exception/error 500)
        $this->assertInstanceOf(\Illuminate\Http\JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());

        $data = $response->getData(true); 

        // 2. Memperbaiki logika pengecekan array 'data' sesuai pembungkus API Anda
        $this->assertArrayHasKey('data', $data);
        
        // 3. Memastikan algoritma filter internal menghasilkan array kosong (size = 0)
        $this->assertEmpty($data['data']);
    }
}