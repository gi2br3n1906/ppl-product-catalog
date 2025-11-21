<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Produk - CampusMarket</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        /* Hide scrollbar untuk semua browser */
        html, body {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        
        html::-webkit-scrollbar,
        body::-webkit-scrollbar {
            display: none;
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
            border-bottom: 3px solid #ACEB02;
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
            display: flex; /* Use flex for centering */
            align-items: center;
            justify-content: center;
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
            display: flex; /* Use flex for centering */
            align-items: center;
            justify-content: center;
        }
        
        .btn-register:hover {
            background: #9dd302;
            border-color: #9dd302;
        }

        .btn-product-action {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 8px 10px; /* Slightly smaller padding for detail button */
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px; /* Smaller font size */
            transition: all 0.2s;
            background:#f8f9fa; 
            border:1px solid #e1e1e1;
            color:#01343B;
        }

        .btn-product-action:hover {
            background: #e0e0e0;
        }

        .btn-product-action.btn-buy {
            background:#ACEB02;
            border: none;
            color: #01343B;
            font-weight: 700;
            padding: 10px; /* Original padding for buy button */
        }

        .btn-product-action.btn-buy:hover {
            background: #9dd302;
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
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .btn-logout:hover {
            background: white;
            color: #01343B;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 60px 20px;
            text-align: center;
        }
        
        .construction-box {
            background: white;
            padding: 80px 40px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        /* Product grid styles */
        .product-grid .product-card {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
        }

        .product-image-wrapper {
            height: 220px;
            display:flex;
            align-items:center;
            justify-content:center;
            overflow:hidden;
            border-radius:6px;
            margin-bottom:12px;
            background: #ffffff;
            padding: 8px;
        }

        .product-image-wrapper img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
            object-position: center center;
            display:block;
        }
        
        .construction-icon {
            font-size: 72px;
            margin-bottom: 20px;
        }
        
        .construction-text {
            color: #01343B;
            font-size: 24px;
            font-weight: 600;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .navbar {
                padding: 15px 20px;
            }
            
            .navbar-brand {
                font-size: 16px;
            }
            
            .navbar-right {
                gap: 10px;
            }
            
            .btn-login, .btn-register, .btn-logout {
                padding: 6px 15px;
                font-size: 14px;
            }
            
            .container {
                padding: 40px 15px;
            }
            
            .construction-box {
                padding: 60px 20px;
            }
            
            .construction-icon {
                font-size: 56px;
            }
            
            .construction-text {
                font-size: 20px;
            }
            .product-image-wrapper {
                height: 160px;
            }
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
        <div class="construction-box" style="text-align: left; padding: 30px;">
            <h2 style="color: #01343B; margin-bottom: 20px;">Katalog Produk</h2>

            @if(session('success'))
                <div style="margin-bottom: 15px; padding: 12px; border-radius: 8px; background: #E8F5E9; color: #155724; font-weight: 600;">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div style="margin-bottom: 15px; padding: 12px; border-radius: 8px; background: #FFEBEE; color: #721C24; font-weight: 600;">{{ session('error') }}</div>
            @endif

            <div style="display:flex; justify-content: space-between; align-items:center; margin-bottom: 15px;">
                <div style="font-weight: 600;">Menampilkan Produk</div>
                <div style="color:#666">Total: {{ $products->total() ?? 0 }}</div>
            </div>

            <div class="product-grid" style="display:grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 20px;">
                @forelse($products as $product)
                    <div class="product-card" style="background: white; padding: 16px; border-radius: 8px; border: 1px solid #e9e9e9;">
                        <div class="product-image-wrapper">
                            @if(!empty($product->image))
                                @php
                                    $imgSrc = $product->image;
                                    if ($imgSrc && !str_starts_with($imgSrc, 'http')) {
                                        $imgSrc = asset('storage/' . ltrim($imgSrc, '/'));
                                    }
                                @endphp
                                <img src="{{ $imgSrc }}" alt="{{ $product->name }}">
                            @else
                                <!-- inline SVG placeholder -->
                                <div style="display:flex;align-items:center;justify-content:center; width:100%; height:100%; background:#f0f0f0; color:#999; font-weight:600;">
                                    Gambar Produk
                                </div>
                            @endif
                        </div>
                        <div style="font-weight:700; color:#01343B; margin-bottom:4px;">{{ $product->name }}</div>
                        <div style="font-weight:600; color:#234; margin-bottom:8px;">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                        <div style="font-size:12px; color:#666; margin-bottom:12px;">Stok: {{ $product->stock }}</div>

                        <!-- Action Buttons -->
                        <div style="display:flex; gap:8px;">
                            <a href="{{ route('product.show', $product) }}" class="btn-product-action" style="flex:1;">Detail</a>
                            
                            @auth
                                <form action="{{ route('cart.add') }}" method="POST" style="display:inline-block; flex:1;">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn-product-action btn-buy">Beli</button>
                                </form>
                            @else
                                <a href="{{ route('login', ['redirect' => route('catalog', ['page' => request()->query('page', 1)]) . '?redirect_product=' . $product->id]) }}" class="btn-product-action btn-buy">Login to Buy</a>
                            @endauth
                        </div>
                    </div>
                @empty
                    <div>Tidak ada produk untuk ditampilkan.</div>
                @endforelse
            </div>

            <div style="margin-top:20px; display:flex; justify-content:center;">
                {{ $products->links() }}
            </div>
        </div>
    </div>

    @if(request()->query('redirect_product') && Auth::check())
        <script>
            // show a small confirm to add product to cart after login
            document.addEventListener('DOMContentLoaded', () => {
                const productId = '{{ request()->query('redirect_product') }}';
                if (productId) {
                    if (confirm('Anda baru saja login — tambahkan produk ini ke keranjang sekarang?')) {
                        // Create a form and POST to cart.add
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = '{{ route('cart.add') }}';
                        const csrf = document.createElement('input');
                        csrf.type = 'hidden';
                        csrf.name = '_token';
                        csrf.value = '{{ csrf_token() }}';
                        const pid = document.createElement('input');
                        pid.type = 'hidden';
                        pid.name = 'product_id';
                        pid.value = productId;
                        const qty = document.createElement('input');
                        qty.type = 'hidden';
                        qty.name = 'quantity';
                        qty.value = 1;
                        form.appendChild(csrf);
                        form.appendChild(pid);
                        form.appendChild(qty);
                        document.body.appendChild(form);
                        form.submit();
                    }
                }
            })
        </script>
    @endif
</body>
</html>
