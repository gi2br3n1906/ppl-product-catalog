<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;


use Illuminate\Support\Facades\Http;

class WilayahController extends Controller
{
    // API eksternal: https://emsifa.github.io/api-wilayah-indonesia/
    public function provinsi()
    {
        $response = Http::get('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json');
        return response()->json($response->json());
    }

    public function kabupaten(Request $request)
    {
        $provinsi_id = $request->query('provinsi_id');
        if (!$provinsi_id) return response()->json([]);
        $response = Http::get("https://www.emsifa.com/api-wilayah-indonesia/api/regencies/$provinsi_id.json");
        return response()->json($response->json());
    }

    public function kecamatan(Request $request)
    {
        $kabupaten_id = $request->query('kabupaten_id');
        if (!$kabupaten_id) return response()->json([]);
        $response = Http::get("https://www.emsifa.com/api-wilayah-indonesia/api/districts/$kabupaten_id.json");
        return response()->json($response->json());
    }

    public function kelurahan(Request $request)
    {
        $kecamatan_id = $request->query('kecamatan_id');
        if (!$kecamatan_id) return response()->json([]);
        $response = Http::get("https://www.emsifa.com/api-wilayah-indonesia/api/villages/$kecamatan_id.json");
        return response()->json($response->json());
    }
}
