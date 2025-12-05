<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\ProductReview;
use App\Models\User;
use App\Models\SellerRegistration;

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
        $user = auth()->user();
        
        // Ambil data stok real dari database
        $products = Product::where('seller_id', $user->id)
            ->select('name', 'stock')
            ->get();

        $labels = $products->pluck('name')->toArray();
        $data = $products->pluck('stock')->toArray();
        
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
        $user = auth()->user();

        // Real query: average rating per product milik seller
        $ratingRows = DB::table('products')
            ->leftJoin('product_reviews', 'products.id', '=', 'product_reviews.product_id')
            ->select('products.name', DB::raw('AVG(product_reviews.rating) as avg_rating'))
            ->where('products.seller_id', $user->id)
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('avg_rating')
            ->get();

        $labels = $ratingRows->pluck('name')->toArray();
        // Jika belum ada rating, avg_rating akan null, kita set jadi 0
        $data = $ratingRows->map(fn($r) => round((float)$r->avg_rating, 2))->toArray();
        $hasData = !empty($data) && array_sum($data) > 0;

        return response()->json(['labels' => $labels, 'data' => $data, 'hasData' => $hasData]);
    }

    /**
     * Mengembalikan data sebaran pemberi rating berdasarkan provinsi
     * GET /api/dashboard/location?product_id={id}
     */
    public function getLocationData(Request $request)
    {
        // Saat ini kita belum menyimpan data lokasi (provinsi) dari reviewer (pengunjung).
        // Jadi kita kembalikan data kosong agar tidak menyesatkan dengan dummy data.
        // Nanti jika fitur checkout sudah ada dan menyimpan alamat pembeli, query ini bisa disesuaikan.
        
        return response()->json([
            'labels' => [], 
            'data' => [], 
            'hasData' => false
        ]);
    }

    /**
     * Mengembalikan daftar produk milik seller
     * GET /api/dashboard/products
     */
    public function getProducts()
    {
        $user = auth()->user();
        
        $products = Product::where('seller_id', $user->id)
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

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

    /**
     * Mengembalikan daftar produk dengan stok menipis (< 2)
     * GET /api/dashboard/low-stock
     */
    public function getLowStockProducts()
    {
        $user = auth()->user();
        
        // Ambil produk dengan stok < 2 milik seller
        $products = Product::where('seller_id', $user->id)
            ->where('stock', '<', 2)
            ->select('name', 'stock')
            ->orderBy('stock', 'asc')
            ->get();

        return response()->json([
            'products' => $products
        ]);
    }

    /**
     * Product category distribution - admin dashboard
     * GET /api/admin/dashboard/product-category-distribution
     */
    public function getProductCategoryDistribution()
    {
        $rows = DB::table('products')
            ->select(DB::raw("COALESCE(category, 'Uncategorized') as category"), DB::raw('COUNT(*) as total'))
            ->groupBy('category')
            ->orderByDesc('total')
            ->get();

        $labels = $rows->pluck('category')->toArray();
        $data = $rows->pluck('total')->map(fn($v) => (int)$v)->toArray();

        return response()->json(['labels' => $labels, 'data' => $data, 'total' => array_sum($data)]);
    }

    /**
     * Sellers distribution by province (approved sellers only)
     * GET /api/admin/dashboard/sellers-by-province
     */
    public function getSellersByProvince()
    {
        $rows = DB::table('seller_registrations')
            ->select('provinsi', DB::raw('COUNT(*) as total'))
            ->where('status', 'approved')
            ->groupBy('provinsi')
            ->orderByDesc('total')
            ->get();

        $labels = $rows->pluck('provinsi')->toArray();
        $data = $rows->pluck('total')->map(fn($v) => (int)$v)->toArray();

        return response()->json(['labels' => $labels, 'data' => $data, 'total' => array_sum($data)]);
    }

    /**
     * Seller status comparison (Active vs Inactive)
     * GET /api/admin/dashboard/seller-status-comparison
     */
    public function getSellerStatusComparison()
    {
        $rows = DB::table('seller_registrations')
            ->select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->get();

        $active = 0; $inactive = 0;
        foreach ($rows as $r) {
            if ($r->status === 'approved') $active = (int)$r->total; else $inactive += (int)$r->total;
        }

        return response()->json(['labels' => ['Active', 'Inactive'], 'data' => [$active, $inactive], 'total' => $active + $inactive]);
    }

    /**
     * Count of unique visitors who wrote reviews (unique reviewer_email)
     * GET /api/admin/dashboard/reviewers-count
     */
    public function getReviewersCount()
    {
        $totalReviews = DB::table('product_reviews')->count();
        $uniqueReviewers = DB::table('product_reviews')->distinct()->count('reviewer_email');

        return response()->json(['total_reviews' => $totalReviews, 'unique_reviewers' => $uniqueReviewers]);
    }

    /**
     * Admin dashboard overview
     * GET /api/admin/dashboard/overview
     */
    public function getOverview()
    {
        $totalProducts = DB::table('products')->count();
        $totalSellers = DB::table('seller_registrations')->count();
        $activeSellers = DB::table('seller_registrations')->where('status', 'approved')->count();
        $inactiveSellers = $totalSellers - $activeSellers;
        $totalReviews = DB::table('product_reviews')->count();
        $averageRating = DB::table('product_reviews')->avg('rating') ?? 0;

        return response()->json([
            'total_products' => $totalProducts,
            'total_sellers' => $totalSellers,
            'active_sellers' => $activeSellers,
            'inactive_sellers' => $inactiveSellers,
            'total_reviews' => $totalReviews,
            'average_rating' => round((float)$averageRating, 2),
        ]);
    }
}
