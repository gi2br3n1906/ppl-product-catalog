<?php

namespace Tests\Unit; 
use Tests\TestCase;
use App\Http\Controllers\ProductController;
use App\Models\User;
use App\Models\Product;
use App\Models\SellerRegistration;
use Illuminate\Http\Request;
use Illuminate\Foundation\Testing\DatabaseTransactions;


class SearchValidKeywordTest extends TestCase
{
    use DatabaseTransactions;
    
    public function test_search_executes_internal_logic_with_valid_keyword()
    {
        // ==========================================
        // 1. SETUP (Sama seperti sebelumnya)
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

        $product = Product::create([
            'name' => 'Kipas Angin Miyako', 'description' => 'Kipas angin bagus',
            'price' => 150000, 'stock' => 10, 'category' => 'Elektronik', 'seller_id' => $seller->id
        ]);

        // ==========================================
        // 2. WHITE-BOX ACTION (Panggilan Langsung ke Komponen Internal)
        // ==========================================
        // Membuat objek Request secara programatis di memori
        $request = Request::create('/api/products/search', 'GET', ['q' => 'Kipas Angin Miyako']);

        // Menginstansiasi Controller secara langsung tanpa lewat Route/URL
        $controller = new ProductController();

        // Mengeksekusi metode internal secara langsung untuk menguji jalurnya (Path)
        $response = $controller->search($request);

        // ==========================================
        // 3. WHITE-BOX ASSERTION
        // ==========================================
        // Memeriksa tipe kembalian objek response internal Laravel
        $this->assertInstanceOf(\Illuminate\Http\JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());

        // Mengubah konten response menjadi array untuk membedah data internal
        $data = $response->getData(true); 

        // 1. Pastikan key 'data' ada dan tidak kosong
        $this->assertArrayHasKey('data', $data);
        $this->assertNotEmpty($data['data']);

        // 2. Akses indeks ke-0 di dalam array 'data' tersebut
        $this->assertEquals('Kipas Angin Miyako', $data['data'][0]['name']);
    }
}