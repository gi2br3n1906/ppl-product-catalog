<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/**
 * [DUPL-05-01] Pengujian Tambah Produk secara valid
 *
 * Skenario:
 *   Seller yang sudah login melakukan POST request ke endpoint
 *   simpan produk dengan seluruh field yang valid, termasuk file
 *   gambar palsu yang dibuat oleh UploadedFile::fake()->image().
 *
 * Ekspektasi:
 *   1. Response berupa redirect ke halaman tabel daftar produk
 *      (route: seller.kelola-produk) → HTTP 302.
 *   2. Session mengandung key 'success' dengan pesan sukses.
 *   3. Record produk benar-benar tersimpan di tabel 'products'
 *      dengan data yang sesuai payload yang dikirimkan.
 */
class DUPL0501Test extends TestCase
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

    public function test_seller_dapat_menambah_produk_dengan_data_valid(): void
    {
        // ── Arrange ──────────────────────────────────────────────────
        // 1. Palsukan disk 'public' agar operasi upload file tidak
        //    benar-benar menulis ke storage fisik. Semua pemanggilan
        //    Storage::disk('public') di controller akan diarahkan ke
        //    filesystem in-memory selama test ini berjalan.
        Storage::fake('public');

        // 2. Buat user seller dan simulasikan login sebagai user tersebut.
        $seller = $this->createSellerUser();

        // 3. Siapkan payload data produk yang valid.
        $payload = [
            'name'          => 'Tas Ransel Kampus Premium',
            'description'   => 'Tas ransel berkualitas tinggi cocok untuk mahasiswa.',
            'price'         => 250000,
            'stock'         => 50,
            'category'      => 'Fashion',
            'primary_image' => UploadedFile::fake()->image('produk.jpg', 640, 480),
        ];

        // ── Act ───────────────────────────────────────────────────────
        // Kirim POST request ke route 'seller.kelola-produk.store'
        // sebagai $seller yang sudah login.
        $response = $this->actingAs($seller)
            ->post(route('seller.kelola-produk.store'), $payload);

        // ── Assert ────────────────────────────────────────────────────

        // 1. Response harus redirect ke halaman daftar produk seller.
        $response->assertRedirect(route('seller.kelola-produk'));

        // 2. Session harus mengandung flash message dengan key 'success'
        //    dan nilai string persis seperti yang di-set oleh controller.
        $response->assertSessionHas('success', 'Produk berhasil ditambahkan!');

        // 3. Verifikasi record produk benar-benar tersimpan di tabel
        //    'products' dengan kolom dan nilai yang sesuai payload.
        $this->assertDatabaseHas('products', [
            'name'      => 'Tas Ransel Kampus Premium',
            'price'     => 250000,
            'stock'     => 50,
            'category'  => 'Fashion',
            'seller_id' => $seller->id,
        ]);
    }
}
