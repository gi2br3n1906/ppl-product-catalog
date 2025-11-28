<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} - Detail Produk</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
            min-height: 100vh;
        }
        
        .navbar {
            background: #01343B;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        
        .navbar-brand {
            font-size: 20px;
            font-weight: 600;
            color: white;
            text-decoration: none;
        }
        
        .navbar-right {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .user-info {
            color: white;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .btn-logout {
            background: transparent;
            border: 2px solid white;
            color: white;
            padding: 8px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.2s;
        }
        
        .btn-logout:hover {
            background: white;
            color: #01343B;
        }
        .btn-login {
            background: #ACEB02;
            border: 2px solid #ACEB02;
            color: #01343B;
            padding: 8px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-login:hover {
            background: #9dd302;
            border-color: #9dd302;
        }

        .btn-register {
            background: #ACEB02;
            border: 2px solid #ACEB02;
            color: #01343B;
            padding: 8px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-register:hover {
            background: #9dd302;
            border-color: #9dd302;
        }
        
        .container {
            max-width: 900px;
            margin: 40px auto;
            padding: 20px;
        }
        
        .product-detail-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            display: flex;
            gap: 30px;
            padding: 30px;
        }

        .product-image-container {
            flex: 1;
            max-width: 400px;
        }

        .product-image {
            width: 100%;
            height: auto;
            border-radius: 6px;
            border: 1px solid #eee;
        }

        .product-info-container {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .product-category {
            background-color: #eee;
            color: #555;
            font-size: 12px;
            font-weight: 600;
            padding: 4px 8px;
            border-radius: 4px;
            align-self: flex-start;
            margin-bottom: 12px;
        }

        .product-name {
            font-size: 28px;
            font-weight: 700;
            color: #01343B;
            margin-bottom: 8px;
        }

        .product-price {
            font-size: 24px;
            font-weight: 600;
            color: #234;
            margin-bottom: 16px;
        }

        .product-stock {
            font-size: 14px;
            color: #666;
            margin-bottom: 20px;
        }

        .product-description {
            font-size: 15px;
            line-height: 1.6;
            color: #333;
            margin-bottom: 24px;
        }
        
        .add-to-cart-form {
            margin-top: auto;
        }

        .btn-add-to-cart {
            width: 100%;
            background: #ACEB02;
            border: none;
            padding: 14px;
            border-radius: 6px;
            font-weight: 700;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-add-to-cart:hover {
            background: #9dd302;
        }

        .back-link {
            display: inline-block;
            margin-bottom: 20px;
            color: #01343B;
            text-decoration: none;
            font-weight: 600;
        }
        .back-link:hover {
            text-decoration: underline;
        }

    </style>
</head>
<body>
    <nav class="navbar">
        <a href="{{ route('catalog') }}" class="navbar-brand">CampusMarket</a>
        
        <div class="navbar-right">
            @auth
                <div class="user-info">
                    <span>Halo, {{ Auth::user()->name }}!</span>
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn-logout">Logout</button>
                    </form>
                </div>
            @else
                <a href="{{ route('login') }}" class="btn-login">Login</a>
            @endauth
        </div>
    </nav>

    <div class="container">
        <a href="{{ route('catalog') }}" class="back-link">&larr; Kembali ke Katalog</a>

        <div class="product-detail-card">
            <div class="product-image-container">
                @php
                    $allImages = isset($product->images) ? collect($product->images) : collect();
                    if ($allImages->count() === 0 && $product->image) {
                        $allImages = collect([(object)[
                            'image_path' => $product->image,
                            'is_primary' => true
                        ]]);
                    }
                @endphp
                <div id="mainImageContainer" style="width:100%; height:320px; display:flex; align-items:center; justify-content:center; background:#f0f0f0; border-radius:6px; position:relative; overflow:hidden;">
                    @if($allImages->count() > 0)
                        <img id="mainProductImage" src="{{ asset('storage/' . ltrim($allImages->first()->image_path, '/')) }}" alt="{{ $product->name }}" class="product-image" style="max-height:100%; max-width:100%; object-fit:contain;">
                    @else
                        <div style="color:#999; font-weight:600;">Gambar Produk</div>
                    @endif
                </div>
                @if($allImages->count() > 1)
                    <div style="display:flex; gap:10px; margin-top:18px; flex-wrap:wrap; justify-content:center;">
                        @foreach($allImages as $img)
                            <img src="{{ asset('storage/' . ltrim($img->image_path, '/')) }}" alt="Gambar {{ $product->name }}" class="thumb-img" style="width:70px; height:70px; object-fit:cover; border-radius:6px; border:2px solid #eee; background:#fafafa; cursor:pointer; transition:border 0.2s;" onclick="document.getElementById('mainProductImage').src=this.src">
                        @endforeach
                    </div>
                @endif
            </div>
            <div class="product-info-container">
                <div class="product-category">{{ $product->category }}</div>
                <h1 class="product-name">{{ $product->name }}</h1>
                <div class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                <div class="product-stock">Stok: {{ $product->stock }}</div>
                <p class="product-description">{{ $product->description }}</p>

                @auth
                    <form action="{{ route('cart.add') }}" method="POST" class="add-to-cart-form">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="btn-add-to-cart">Tambah ke Keranjang</button>
                    </form>
                @else
                    <a href="{{ route('login', ['redirect' => route('product.show', $product)]) }}" class="btn-add-to-cart" style="display: block; text-align: center; text-decoration: none; color: #01343B;">Login untuk Beli</a>
                @endauth
            </div>
        </div>
    </div>
</body>
</html>
