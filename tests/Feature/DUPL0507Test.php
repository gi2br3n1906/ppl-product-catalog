<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;

/**
 * [DUPL-05-07] Pengujian Edit Produk – Memperbarui Kolom "Deskripsi"
 *
 * Skenario:
 *   Seller yang sudah login memiliki satu produk di database.
 *   Seller melakukan PUT request ke endpoint update produk dengan
 *   mengubah nilai kolom 'description' menjadi teks baru.
 *
 * Ekspektasi:
 *   1. Response berupa redirect ke halaman daftar produk → HTTP 302.
 *   2. Session mengandung key 'success' dengan pesan sukses.
 *   3. Kolom 'description' pada record produk tersebut di database
 *      sudah tertimpa dengan nilai "Teks Baru".
 */
class DUPL0507Test extends TestCase
{
    use RefreshDatabase;

    /**
     * Membuat user dengan role 'seller' menggunakan UserFactory.
     * Role ini diperlukan agar Controller dapat mengaitkan produk
     * dengan seller yang sedang login (seller_id = auth()->id()).
     */
    private function createSellerUser(): User
    {
        return User::factory()->create([
            'role' => 'seller',
        ]);
    }

    public function test_seller_dapat_memperbarui_deskripsi_produk(): void
    {
        // ── Arrange ──────────────────────────────────────────────────
        // 1. Palsukan disk 'public' (dibutuhkan karena controller
        //    mengimpor Storage dan bisa memprosesnya jika ada upload).
        Storage::fake('public');

        // 2. Buat user seller dan simulasikan login.
        $seller = $this->createSellerUser();

        // 3. Buat satu produk dummy langsung via Product::create(),
        //    mengikuti pola yang sama dengan ProductSeeder.
        //    seller_id diisi dengan ID $seller agar authorization check
        //    di dalam controller berhasil (controller melakukan:
        //    Product::where('id', $id)->where('seller_id', auth()->id())->firstOrFail()).
        $produkLama = Product::create([
            'seller_id'   => $seller->id,
            'name'        => 'Buku Tulis Sinar Dunia 58 Lembar',
            'description' => 'Deskripsi lama yang akan diganti oleh test ini.',
            'price'       => 38000,
            'stock'       => 120,
            'category'    => 'Alat Tulis',
        ]);

        // 4. Siapkan payload untuk request update.
        $deskripsiBaruTeks = 'Teks Baru';

        $payload = [
            'name'        => $produkLama->name, 
            'description' => $deskripsiBaruTeks,    
            'price'       => $produkLama->price,   
            'stock'       => $produkLama->stock,   
            'category'    => $produkLama->category, 
        ];

        // ── Act ───────────────────────────────────────────────────────
        // Kirim PUT request ke route 'seller.produk.update' dengan
        // ID produk dummy yang sudah dibuat, sebagai $seller yang login.
        $response = $this->actingAs($seller)
            ->put(route('seller.produk.update', $produkLama->id), $payload);

        // ── Assert ────────────────────────────────────────────────────

        // 1. Response harus redirect ke halaman daftar produk seller.
        $response->assertRedirect(route('seller.kelola-produk'));

        // 2. Session harus mengandung flash message sukses.
        $response->assertSessionHas('success', 'Produk berhasil diperbarui!');

        // 3. Verifikasi bahwa record produk di database sudah diperbarui.
        $this->assertDatabaseHas('products', [
            'id'          => $produkLama->id,
            'description' => $deskripsiBaruTeks,
        ]);
    }
}
