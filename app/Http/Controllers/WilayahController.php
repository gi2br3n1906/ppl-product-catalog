<?php
// filepath: d:\Coding\PPL\ppl-product-catalog\app\Http\Controllers\WilayahController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Http;

class WilayahController extends Controller
{
    public function provinsi()
    {
        $response = Http::withoutVerifying()
            ->get('https://wilayah.id/api/provinces.json');
        return response()->json($response->json());
    }

    public function kabupaten(Request $request)
    {
        $provinsi_id = $request->query('provinsi_id');
        if (!$provinsi_id) return response()->json([]);
        $response = Http::withoutVerifying()
            ->get("https://wilayah.id/api/regencies/$provinsi_id.json");
        return response()->json($response->json());
    }

    public function kecamatan(Request $request)
    {
        $kabupaten_id = $request->query('kabupaten_id');
        if (!$kabupaten_id) return response()->json([]);
        $response = Http::withoutVerifying()
            ->get("https://wilayah.id/api/districts/$kabupaten_id.json");
        return response()->json($response->json());
    }

    public function kelurahan(Request $request)
    {
        $kecamatan_id = $request->query('kecamatan_id');
        if (!$kecamatan_id) return response()->json([]);
        $response = Http::withoutVerifying()
            ->get("https://wilayah.id/api/villages/$kecamatan_id.json");
        return response()->json($response->json());
    }
}