<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;

class DashboardController extends Controller
{
    /**
     * Mengembalikan data penjualan bulanan
     * GET /api/dashboard/sales?year={year}
     */
    public function getSalesData(Request $request)
    {
        $year = $request->query('year', date('Y')); // Default tahun saat ini
        
        // TODO: Sesuaikan dengan db kalo udah ada
        // Contoh query untuk mendapatkan total penjualan per bulan untuk tahun tertentu
        // $salesData = DB::table('orders')
        //     ->select(DB::raw('MONTH(created_at) as month'), DB::raw('SUM(total_amount) as total'))
        //     ->where('status', 'completed')
        //     ->whereYear('created_at', $year)
        //     ->groupBy('month')
        //     ->get();

        // Dummy data 
        $labels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        
        if ($year == 2025) {
            $data = [450000, 520000, 380000, 620000, 750000, 680000, 890000, 720000, 650000, 780000, 920000, 850000];
        } elseif ($year == 2024) {
            $data = [380000, 420000, 350000, 480000, 620000, 580000, 720000, 650000, 590000, 680000, 820000, 750000];
        } elseif ($year == 2023) {
            $data = [320000, 380000, 290000, 410000, 520000, 480000, 630000, 580000, 520000, 590000, 720000, 650000];
        } else {
            $data = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
        }
        
        // Cek apakah ada data
        $hasData = !empty($data) && array_sum($data) > 0;

        return response()->json([
            'labels' => $labels,
            'data' => $data,
            'hasData' => $hasData,
            'total' => array_sum($data)
        ]);
    }

    /**
     * Mengembalikan data jumlah stok per produk
     * GET /api/dashboard/stock
     */
    public function getStockData()
    {
        // Contoh query untuk mendapatkan stok per produk
        // $stockData = DB::table('products')
        //     ->select('name', 'stock')
        //     ->where('seller_id', auth()->id())
        //     ->get();

        // Dummy data
        $labels = ['Buku Tulis', 'Pulpen Hitam', 'Penggaris 30cm', 'Penghapus', 'Pensil 2B'];
        $data = [150, 200, 75, 120, 180];
        
        // Cek apakah ada data
        $hasData = !empty($data) && array_sum($data) > 0;

        return response()->json([
            'labels' => $labels,
            'data' => $data,
            'hasData' => $hasData
        ]);
    }

    /**
     * Mengembalikan data rata-rata rating per produk
     * GET /api/dashboard/rating
     */
    public function getRatingData()
    {
        // Contoh query untuk mendapatkan rata-rata rating per produk
        // $ratingData = DB::table('products')
        //     ->leftJoin('reviews', 'products.id', '=', 'reviews.product_id')
        //     ->select('products.name', DB::raw('AVG(reviews.rating) as avg_rating'))
        //     ->where('products.seller_id', auth()->id())
        //     ->groupBy('products.id', 'products.name')
        //     ->get();

        // Dummy data
        $labels = ['Buku Tulis', 'Pulpen Hitam', 'Penggaris 30cm', 'Penghapus', 'Pensil 2B'];
        $data = [4.5, 4.8, 4.2, 4.6, 4.9];
        
        // Cek apakah ada data
        $hasData = !empty($data) && array_sum($data) > 0;

        return response()->json([
            'labels' => $labels,
            'data' => $data,
            'hasData' => $hasData
        ]);
    }

    /**
     * Mengembalikan data sebaran pemberi rating berdasarkan provinsi
     * GET /api/dashboard/location?product_id={id}
     */
    public function getLocationData(Request $request)
    {
        $productId = $request->query('product_id');
        
        // Contoh query untuk mendapatkan sebaran pemberi rating per provinsi untuk produk tertentu
        // if ($productId) {
        //     $locationData = DB::table('reviews')
        //         ->join('users', 'reviews.user_id', '=', 'users.id')
        //         ->join('products', 'reviews.product_id', '=', 'products.id')
        //         ->select('users.province', DB::raw('COUNT(*) as total'))
        //         ->where('products.id', $productId)
        //         ->where('products.seller_id', auth()->id())
        //         ->groupBy('users.province')
        //         ->get();
        // }

        // Dummy data
        // Data berbeda berdasarkan product_id untuk simulasi
        if ($productId == 1) {
            $labels = ['Jawa Barat', 'Jawa Tengah', 'DKI Jakarta', 'Bali'];
            $data = [45, 32, 52, 18];
        } elseif ($productId == 2) {
            $labels = ['Jawa Timur', 'Jawa Tengah', 'Sumatra Utara', 'DKI Jakarta'];
            $data = [38, 25, 25, 30];
        } elseif ($productId == 3) {
            $labels = ['DKI Jakarta', 'Jawa Barat', 'Bali'];
            $data = [60, 40, 20];
        } else {
            // Default: semua produk
            $labels = ['Jawa Barat', 'Jawa Tengah', 'Jawa Timur', 'DKI Jakarta', 'Bali', 'Sumatra Utara'];
            $data = [45, 32, 38, 52, 18, 25];
        }
        
        // Cek apakah ada data
        $hasData = !empty($data) && array_sum($data) > 0;

        return response()->json([
            'labels' => $labels,
            'data' => $data,
            'hasData' => $hasData
        ]);
    }

    /**
     * Mengembalikan daftar produk milik seller
     * GET /api/dashboard/products
     */
    public function getProducts()
    {
        // Contoh query untuk mendapatkan produk milik seller yang sedang login
        // $products = Product::where('seller_id', auth()->id())
        //     ->select('id', 'name')
        //     ->get();

        // Dummy data
        $products = [
            ['id' => 1, 'name' => 'Buku Tulis Spiral A5'],
            ['id' => 2, 'name' => 'Pulpen Hitam 0.5mm'],
            ['id' => 3, 'name' => 'Penggaris 30cm'],
            ['id' => 4, 'name' => 'Penghapus Putih'],
            ['id' => 5, 'name' => 'Pensil 2B (Pack 12)'],
        ];

        return response()->json([
            'products' => $products
        ]);
    }

    /**
     * Mengembalikan daftar tahun yang tersedia untuk data penjualan
     * GET /api/dashboard/years
     */
    public function getYears()
    {
        // Contoh query untuk mendapatkan tahun-tahun yang memiliki data penjualan
        // $years = DB::table('orders')
        //     ->selectRaw('DISTINCT YEAR(created_at) as year')
        //     ->where('seller_id', auth()->id())
        //     ->orderBy('year', 'desc')
        //     ->pluck('year');

        // Dummy data
        $currentYear = (int) date('Y');
        $years = [
            $currentYear,      // 2025 (prioritas)
            $currentYear - 1,  // 2024
            $currentYear - 2,  // 2023
        ];

        return response()->json([
            'years' => $years,
            'current_year' => $currentYear
        ]);
    }
}
