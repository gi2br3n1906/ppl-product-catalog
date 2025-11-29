<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf; // Ensure composer require barryvdh/laravel-dompdf

class ReportController extends Controller
{
    /**
     * Sellers report (filter by status, province)
     * GET /api/admin/reports/sellers
     */
    public function sellersReport(Request $request)
    {
        $status = $request->query('status');
        $province = $request->query('province');
        $search = $request->query('q');

        $query = DB::table('seller_registrations')
            ->select('id', 'nama_toko', 'nama_pic', 'email_pic', 'provinsi', 'status', 'verified_at', 'created_at')
            ->orderBy('created_at', 'desc');

        if ($status) $query->where('status', $status);
        if ($province) $query->where('provinsi', $province);
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama_toko', 'like', "%{$search}%")
                  ->orWhere('nama_pic', 'like', "%{$search}%")
                  ->orWhere('email_pic', 'like', "%{$search}%");
            });
        }

        $rows = $query->get();

        // Return PDF if requested
        if ($request->query('format') === 'pdf') {
            $data = ['sellers' => $rows, 'filters' => ['status' => $status, 'province' => $province, 'q' => $search]];
            if (class_exists(Pdf::class)) {
                $pdf = Pdf::loadView('admin.reports.sellers-pdf', $data);
                return $pdf->download('sellers-report-' . now()->format('Ymd_His') . '.pdf');
            }
            return response()->json(['error' => 'PDF generation not available. Please install barryvdh/laravel-dompdf (composer require barryvdh/laravel-dompdf)'], 501);
        }

        return response()->json(['sellers' => $rows]);
    }

    /**
     * Location report (sellers grouped/filtered by province)
     * GET /api/admin/reports/locations
     */
    public function locationsReport(Request $request)
    {
        $province = $request->query('province');

        $query = DB::table('seller_registrations')
            ->select('provinsi', DB::raw('COUNT(*) as total'))
            ->groupBy('provinsi')
            ->orderByDesc('total');

        if ($province) $query->where('provinsi', $province);

        $rows = $query->get();

        // Also return detailed seller listings if requested
        $detailed = [];
        if ($province) {
            $detailed = DB::table('seller_registrations')
                ->select('id', 'nama_toko', 'nama_pic', 'email_pic', 'provinsi', 'status')
                ->where('provinsi', $province)
                ->orderBy('nama_toko')
                ->get();
        }

        if ($request->query('format') === 'pdf') {
            $data = ['locations' => $rows, 'detailed' => $detailed, 'filters' => ['province' => $province]];
            if (class_exists(Pdf::class)) {
                $pdf = Pdf::loadView('admin.reports.locations-pdf', $data);
                return $pdf->download('locations-report-' . now()->format('Ymd_His') . '.pdf');
            }
            return response()->json(['error' => 'PDF generation not available. Please install barryvdh/laravel-dompdf'], 501);
        }

        return response()->json(['locations' => $rows, 'detailed' => $detailed]);
    }

    /**
     * Top products report (sorted by rating desc) include store name, category, price, province
     * GET /api/admin/reports/top-products?limit=50&category=&province=
     */
    public function topProductsReport(Request $request)
    {
        $limit = (int) $request->query('limit', 50);
        $category = $request->query('category');
        $province = $request->query('province');

        $sub = DB::table('products as p')
            ->leftJoin('product_reviews as pr', 'pr.product_id', '=', 'p.id')
            ->leftJoin('users as u', 'p.seller_id', '=', 'u.id')
            ->leftJoin('seller_registrations as sr', 'sr.email_pic', '=', 'u.email')
            ->select('p.id', 'p.name', 'p.price', 'p.category', 'u.name as store_name', 'sr.provinsi', DB::raw('AVG(pr.rating) as avg_rating'), DB::raw('COUNT(pr.id) as total_reviews'))
            ->groupBy('p.id', 'p.name', 'p.price', 'p.category', 'u.name', 'sr.provinsi')
            ->orderByDesc('avg_rating');

        if ($category) $sub->where('p.category', $category);
        if ($province) $sub->where('sr.provinsi', $province);

        $rows = $sub->limit($limit)->get();

        if ($request->query('format') === 'pdf') {
            $data = ['products' => $rows, 'filters' => ['limit' => $limit, 'category' => $category, 'province' => $province]];
            if (class_exists(Pdf::class)) {
                $pdf = Pdf::loadView('admin.reports.top-products-pdf', $data);
                return $pdf->download('top-products-report-' . now()->format('Ymd_His') . '.pdf');
            }
            return response()->json(['error' => 'PDF generation not available. Please install barryvdh/laravel-dompdf'], 501);
        }

        return response()->json(['products' => $rows]);
    }
}
