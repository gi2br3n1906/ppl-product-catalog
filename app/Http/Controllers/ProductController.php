<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the products (public catalog).
     */
    public function index(Request $request)
    {
        // TODO: Add filters, categories, search, etc. For now simple pagination
        $products = Product::orderBy('created_at', 'desc')->paginate(12);

        return view('catalog', compact('products'));
    }

    /**
     * Display the specified product.
     */
    public function show(Product $product)
    {
        return view('product.show', compact('product'));
    }
}
