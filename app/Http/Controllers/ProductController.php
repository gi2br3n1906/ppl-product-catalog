<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage; // Penting untuk hapus file fisik

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // Redirect user yang sudah login ke dashboard masing-masing
        if (auth()->check()) {
            $user = auth()->user();
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('seller.dashboard');
        }

        $products = Product::with('images')->orderBy('created_at', 'desc')->paginate(12);
        return view('catalog', compact('products'));
    }

    /**
     * AJAX product search for catalog
     * GET /api/products/search?q={query}&category={category}&store={store}&province={province}&city={city}&page={page}&per_page={per_page}
     */
    public function search(Request $request)
    {
        $q = trim((string) $request->query('q', ''));
        $category = $request->query('category');
        $store = trim((string) $request->query('store', ''));
        $province = $request->query('province');
        $city = $request->query('city');
        $perPage = max(6, (int) $request->query('per_page', 12));
        $page = max(1, (int) $request->query('page', 1));

        $query = Product::with(['images', 'seller'])
            ->join('users', 'products.seller_id', '=', 'users.id')
            ->leftJoin('seller_registrations', 'seller_registrations.email_pic', '=', 'users.email')
            ->select('products.*')
            ->orderBy('products.created_at', 'desc');

        if ($q !== '') {
            $query->where(function ($qb) use ($q) {
                $qb->where('products.name', 'like', "%{$q}%")
                   ->orWhere('products.description', 'like', "%{$q}%");
            });
        }

        if ($category) {
            $query->where('products.category', $category);
        }

        // Filter berdasarkan nama toko
        if ($store !== '') {
            $query->where('seller_registrations.nama_toko', 'like', "%{$store}%");
        }

        // Filter berdasarkan provinsi
        if ($province) {
            $query->where('seller_registrations.provinsi', $province);
        }

        // Filter berdasarkan kabupaten/kota
        if ($city) {
            $query->where('seller_registrations.kab_kota', $city);
        }

        $paginator = $query->paginate($perPage, ['*'], 'page', $page);

        // Map product data for JSON: include primary image url
        $items = collect($paginator->items())->map(function ($product) {
            $primaryImage = isset($product->images) ? collect($product->images)->where('is_primary', true)->first() : null;
            $img = $primaryImage ? asset('storage/' . $primaryImage->image_path) : null;
            return [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'stock' => $product->stock,
                'category' => $product->category,
                'image' => $img,
                'slug' => route('product.show', $product),
            ];
        })->toArray();

        return response()->json([
            'data' => $items,
            'meta' => [
                'total' => $paginator->total(),
                'per_page' => $paginator->perPage(),
                'current_page' => $paginator->currentPage(),
                'last_page' => $paginator->lastPage(),
            ],
        ]);
    }

    public function show(Product $product)
    {
        // Load seller dan registrasi seller untuk mendapatkan info toko
        $product->load(['seller', 'seller.sellerRegistration']);
        return view('product.show', compact('product'));
    }

    // Submit review produk
    public function submitReview(Request $request, Product $product)
    {
        $request->validate([
            'reviewer_name' => 'required|string|max:100',
            'reviewer_phone' => 'required|string|max:20',
            'reviewer_email' => 'required|email|max:100',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $review = $product->reviews()->create([
            'reviewer_name' => $request->reviewer_name,
            'reviewer_phone' => $request->reviewer_phone,
            'reviewer_email' => $request->reviewer_email,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        // Kirim email terima kasih beserta detail produk dan ulasan
        try {
            $emailBody = "Terima kasih telah memberikan ulasan dan rating untuk produk kami!\n\n" .
                "Detail Produk:\n" .
                "Nama Produk: {$product->name}\n" .
                "Kategori: {$product->category}\n" .
                "Harga: Rp " . number_format($product->price, 0, ',', '.') . "\n\n" .
                "Ulasan Anda:\n" .
                "Rating: {$review->rating} / 5\n" .
                "Komentar: {$review->comment}\n\n" .
                "Salam,\nCampusMarket";
            \Mail::raw($emailBody, function ($message) use ($review, $product) {
                $message->to($review->reviewer_email)
                    ->subject('Terima Kasih atas Ulasan Anda untuk ' . $product->name);
            });
            $review->email_sent = true;
            $review->email_sent_at = now();
            $review->save();
        } catch (\Exception $e) {
            // Email gagal dikirim, tetap simpan review
        }

        return redirect()->route('product.show', $product)->with('review_success', 'Terima kasih atas ulasan Anda!');
    }

    public function kelolaProduk(Request $request)
    {
        $user = auth()->user();
        // Ambil produk milik seller yang sedang login saja
        $products = Product::with('images')->where('seller_id', $user->id)->get();
        return view('seller.kelola-produk', compact('products'));
    }

    public function storeProduk(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'category' => 'required|string|max:255',
            'primary_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        DB::beginTransaction();
        try {
            $user = auth()->user();
            $product = Product::create([
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'stock' => $request->stock,
                'category' => $request->category,
                'seller_id' => $user->id,
            ]);

            // Simpan gambar utama
            if ($request->hasFile('primary_image')) {
                $primaryPath = $request->file('primary_image')->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $primaryPath,
                    'is_primary' => true,
                ]);
            }

            // Simpan gambar tambahan
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $img) {
                    $imgPath = $img->store('products', 'public');
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $imgPath,
                        'is_primary' => false,
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('seller.kelola-produk')->with('success', 'Produk berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['msg' => 'Gagal menambah produk: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * UPDATE PRODUK
     */
    public function updateProduk(Request $request, $id)
    {
        // Pastikan produk milik seller yang login
        $product = Product::where('id', $id)->where('seller_id', auth()->id())->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'category' => 'required|string|max:255',
            'primary_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Nullable saat edit
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        DB::beginTransaction();
        try {
            // Update data teks
            $product->update([
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'stock' => $request->stock,
                'category' => $request->category,
            ]);

            // Jika ada upload gambar utama baru
            if ($request->hasFile('primary_image')) {
                // 1. Cari gambar lama
                $oldPrimary = ProductImage::where('product_id', $product->id)->where('is_primary', true)->first();
                
                // 2. Hapus file lama dari storage & database
                if ($oldPrimary) {
                    Storage::disk('public')->delete($oldPrimary->image_path);
                    $oldPrimary->delete();
                }

                // 3. Upload yang baru
                $primaryPath = $request->file('primary_image')->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $primaryPath,
                    'is_primary' => true,
                ]);
            }

            // Jika ada upload gambar tambahan (Append/Tambah lagi)
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $img) {
                    $imgPath = $img->store('products', 'public');
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $imgPath,
                        'is_primary' => false,
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('seller.kelola-produk')->with('success', 'Produk berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['msg' => 'Gagal update produk: ' . $e->getMessage()]);
        }
    }

    /**
     * HAPUS PRODUK (KESELURUHAN)
     */
    public function destroyProduk($id)
    {
        $product = Product::where('id', $id)->where('seller_id', auth()->id())->firstOrFail();

        // Hapus semua file gambar dari storage
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }

        // Hapus record di DB (Cascade akan menghapus data di tabel product_images juga)
        $product->delete();

        return redirect()->route('seller.kelola-produk')->with('success', 'Produk berhasil dihapus.');
    }

    /**
     * HAPUS SATU GAMBAR SPESIFIK (Fitur Tombol Silang)
     */
    public function deleteImage($id)
    {
        // 1. Cari data gambar berdasarkan ID
        $image = ProductImage::find($id);

        if (!$image) {
            return response()->json(['status' => 'error', 'message' => 'Gambar tidak ditemukan'], 404);
        }

        // 2. Cek Keamanan: Pastikan produknya milik seller yang sedang login
        $product = Product::where('id', $image->product_id)->where('seller_id', auth()->id())->first();
        
        if (!$product) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized Access'], 403);
        }

        // 3. Hapus File Fisik di Storage
        if (Storage::disk('public')->exists($image->image_path)) {
            Storage::disk('public')->delete($image->image_path);
        }

        // 4. Hapus Record di Database
        $image->delete();

        return response()->json(['status' => 'success', 'message' => 'Gambar berhasil dihapus']);
    }
}