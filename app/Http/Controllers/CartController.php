<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    /**
     * Add a product to session cart (minimalistic implementation).
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id' => ['required', 'integer'],
            'quantity' => ['nullable', 'integer'],
        ]);

        $product = Product::find($data['product_id']);
        if (!$product) {
            return back()->with('error', 'Produk tidak ditemukan.');
        }

        $quantity = max(1, (int) ($data['quantity'] ?? 1));
        if ($product->stock < $quantity) {
            return back()->with('error', 'Stok produk tidak mencukupi.');
        }

        // Minimal: Store in session cart array [id => ['quantity', 'price', 'name']]
        $cart = session('cart', []);
        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $quantity;
        } else {
            $cart[$product->id] = [
                'quantity' => $quantity,
                'price' => $product->price,
                'name' => $product->name,
                'image' => $product->image,
            ];
        }

        session(['cart' => $cart]);

        return back()->with('success', 'Produk berhasil ditambahkan ke keranjang (session).');
    }
}
