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
        
        /* Add-to-cart (buy) flow removed: we only show product details for now */

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

        .nav-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background-color: rgba(0, 0, 0, 0.2);
            color: white;
            border: none;
            padding: 8px;
            cursor: pointer;
            border-radius: 50%;
            transition: background-color 0.3s;
            user-select: none;
            z-index: 10;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
        }
        .nav-btn:hover {
            background-color: rgba(0, 0, 0, 0.5);
        }
        .prev-btn { left: 10px; }
        .next-btn { right: 10px; }

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
                <a href="{{ route('seller.register.form') }}" class="btn-register">Daftar Seller</a>
            @endauth
        </div>
    </nav>

    <div class="container">
        @if(Auth::check() && Auth::id() == $product->seller_id)
            <a href="{{ route('seller.kelola-produk') }}" class="back-link">&larr; Kembali ke Kelola Produk</a>
        @else
            <a href="{{ route('catalog') }}" class="back-link">&larr; Kembali ke Katalog</a>
        @endif

        @if(Auth::check() && Auth::id() == $product->seller_id)
            <div style="margin-bottom: 20px; padding: 15px; background: #ecfdf5; border: 1px solid #10b981; border-radius: 8px; display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <strong style="color: #065f46; display: block; margin-bottom: 4px;">Preview Mode</strong>
                    <span style="font-size: 13px; color: #047857;">Ini adalah tampilan produk Anda di mata pembeli.</span>
                </div>
                <div style="display: flex; gap: 10px;">
                    <a href="{{ route('seller.kelola-produk', ['edit_id' => $product->id]) }}" style="background: #01343B; color: white; padding: 8px 16px; border-radius: 6px; text-decoration: none; font-weight: 600; font-size: 14px;">Edit Produk</a>
                    
                    <form action="{{ route('seller.produk.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus produk ini?');" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="background: #ef4444; color: white; padding: 8px 16px; border-radius: 6px; border: none; font-weight: 600; font-size: 14px; cursor: pointer;">Hapus Produk</button>
                    </form>
                </div>
            </div>
        @endif

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
                        
                        @if($allImages->count() > 1)
                            <button class="nav-btn prev-btn" onclick="changeImage(-1)">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M15 18l-6-6 6-6"/></svg>
                            </button>
                            <button class="nav-btn next-btn" onclick="changeImage(1)">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18l6-6-6-6"/></svg>
                            </button>
                        @endif
                    @else
                        <div style="color:#999; font-weight:600;">Gambar Produk</div>
                    @endif
                </div>
                @if($allImages->count() > 1)
                    <div style="display:flex; gap:10px; margin-top:18px; flex-wrap:wrap; justify-content:center;">
                        @foreach($allImages as $index => $img)
                            <img src="{{ asset('storage/' . ltrim($img->image_path, '/')) }}" 
                                 alt="Gambar {{ $product->name }}" 
                                 class="thumb-img" 
                                 style="width:70px; height:70px; object-fit:cover; border-radius:6px; border:2px solid #eee; background:#fafafa; cursor:pointer; transition:border 0.2s;" 
                                 onclick="setImage({{ $index }})">
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
                
                @php
                    $sellerReg = $product->seller?->sellerRegistration;
                @endphp
                
                @if($sellerReg)
                    <div style="margin-top: 16px; padding-top: 16px; border-top: 1px solid #e5e7eb;">
                        <div style="font-size: 14px; color: #666; margin-bottom: 6px;">
                            <strong style="color: #01343B;">Toko:</strong> {{ $sellerReg->nama_toko }}
                        </div>
                        <div style="font-size: 14px; color: #666;">
                            <strong style="color: #01343B;">Lokasi:</strong> {{ $sellerReg->kab_kota }}, {{ $sellerReg->provinsi }}
                        </div>
                    </div>
                @endif

                <!-- Buy flow removed: showing detail only -->
            </div>
        </div>
            <!-- ULASAN PRODUK -->
            <div style="margin-top:40px;">
                <h2 style="color:#01343B; font-size:22px; font-weight:700; margin-bottom:18px;">Ulasan Produk</h2>
                @php
                    $reviews = $product->reviews()->latest()->get();
                    $avgRating = $reviews->count() ? round($reviews->avg('rating'), 2) : null;
                @endphp
                <div style="margin-bottom:18px;">
                    <span style="font-size:18px; font-weight:600; color:#234;">Rating Rata-rata: </span>
                    @if($avgRating)
                        <span style="font-size:18px; color:#FFD700; font-weight:700;">{{ $avgRating }} / 5</span>
                    @else
                        <span style="color:#999;">Belum ada rating</span>
                    @endif
                    <span style="font-size:14px; color:#666; margin-left:10px;">({{ $reviews->count() }} ulasan)</span>
                </div>
                <div style="max-height:320px; overflow-y:auto; background:#fff; border-radius:8px; box-shadow:0 2px 8px rgba(0,0,0,0.06); padding:18px 20px; margin-bottom:30px;">
                    @forelse($reviews as $review)
                        <div style="border-bottom:1px solid #eee; padding-bottom:14px; margin-bottom:14px;">
                            <div style="font-weight:600; color:#01343B;">{{ $review->reviewer_name }}</div>
                            <div style="font-size:13px; color:#666;">{{ $review->reviewer_email }} | {{ $review->reviewer_phone }}</div>
                            @if($review->provinsi)
                                <div style="font-size:13px; color:#666; margin-top:2px;">
                                    <span style="background:#e0f2fe; color:#0369a1; padding:2px 8px; border-radius:4px; font-weight:500;">{{ $review->provinsi }}</span>
                                </div>
                            @endif
                            <div style="margin:6px 0;">
                                <span style="color:#FFD700; font-weight:700; font-size:15px;">{{ $review->rating }} / 5</span>
                            </div>
                            <div style="font-size:15px; color:#333;">{{ $review->comment }}</div>
                            <div style="font-size:12px; color:#aaa; margin-top:4px;">{{ $review->created_at->format('d M Y H:i') }}</div>
                        </div>
                    @empty
                        <div style="color:#999; text-align:center;">Belum ada ulasan untuk produk ini.</div>
                    @endforelse
                </div>
                <!-- FORM ULASAN -->
                <div style="background:#fff; border-radius:8px; box-shadow:0 2px 8px rgba(0,0,0,0.06); padding:22px 24px;">
                    <h3 style="color:#01343B; font-size:18px; font-weight:600; margin-bottom:12px;">Tulis Ulasan & Rating</h3>
                    <form method="POST" action="{{ route('product.review', $product) }}">
                        @csrf
                        <div style="margin-bottom:12px;">
                            <label for="reviewer_name" style="font-weight:500;">Nama</label><br>
                            <input type="text" name="reviewer_name" id="reviewer_name" required style="width:100%; padding:8px; border-radius:6px; border:1px solid #ccc;">
                            @error('reviewer_name')<div style="color:#c00; font-size:13px;">{{ $message }}</div>@enderror
                        </div>
                        <div style="margin-bottom:12px;">
                            <label for="reviewer_phone" style="font-weight:500;">Nomor HP</label><br>
                            <input type="text" name="reviewer_phone" id="reviewer_phone" required style="width:100%; padding:8px; border-radius:6px; border:1px solid #ccc;">
                            @error('reviewer_phone')<div style="color:#c00; font-size:13px;">{{ $message }}</div>@enderror
                        </div>
                        <div style="margin-bottom:12px;">
                            <label for="reviewer_email" style="font-weight:500;">Email</label><br>
                            <input type="email" name="reviewer_email" id="reviewer_email" required style="width:100%; padding:8px; border-radius:6px; border:1px solid #ccc;">
                            @error('reviewer_email')<div style="color:#c00; font-size:13px;">{{ $message }}</div>@enderror
                        </div>
                        <div style="margin-bottom:12px;">
                            <label for="provinsi" style="font-weight:500;">Provinsi</label><br>
                            <select name="provinsi" id="provinsi" required style="width:100%; padding:8px; border-radius:6px; border:1px solid #ccc;">
                                <option value="">Pilih Provinsi</option>
                            </select>
                            @error('provinsi')<div style="color:#c00; font-size:13px;">{{ $message }}</div>@enderror
                        </div>
                        <div style="margin-bottom:12px;">
                            <label for="rating" style="font-weight:500;">Rating (1-5)</label><br>
                            <select name="rating" id="rating" required style="width:100%; padding:8px; border-radius:6px; border:1px solid #ccc;">
                                <option value="">Pilih rating</option>
                                @for($i=1; $i<=5; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                            @error('rating')<div style="color:#c00; font-size:13px;">{{ $message }}</div>@enderror
                        </div>
                        <div style="margin-bottom:12px;">
                            <label for="comment" style="font-weight:500;">Komentar/Ulasan</label><br>
                            <textarea name="comment" id="comment" rows="3" style="width:100%; padding:8px; border-radius:6px; border:1px solid #ccc;"></textarea>
                            @error('comment')<div style="color:#c00; font-size:13px;">{{ $message }}</div>@enderror
                        </div>
                        <button type="submit" style="background:#ACEB02; color:#01343B; font-weight:700; border:none; border-radius:6px; padding:10px 24px; cursor:pointer;">Kirim Ulasan</button>
                    </form>
                    @if(session('review_success'))
                        <div style="margin-top:14px; color:#155724; background:#E8F5E9; padding:10px; border-radius:6px; font-weight:600;">{{ session('review_success') }}</div>
                    @endif
                </div>
            </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const provinceSelect = document.getElementById('provinsi');
            
            // Helper function untuk mengambil data dari response
            function getDataArray(response) {
                // API wilayah.id mengembalikan { data: [...] }
                if (response && response.data && Array.isArray(response.data)) {
                    return response.data;
                }
                // Jika response langsung array
                if (Array.isArray(response)) {
                    return response;
                }
                return [];
            }
            
            // Load provinces
            fetch('/api/wilayah/provinsi')
                .then(response => response.json())
                .then(response => {
                    const data = getDataArray(response);
                    data.forEach(item => {
                        const option = document.createElement('option');
                        option.value = item.name;
                        option.textContent = item.name;
                        provinceSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error loading provinces:', error));
        });

        // Image Gallery Logic
        const productImages = [
            @if(isset($allImages) && $allImages->count() > 0)
                @foreach($allImages as $img)
                    "{{ asset('storage/' . ltrim($img->image_path, '/')) }}",
                @endforeach
            @endif
        ];
        
        let currentImageIndex = 0;

        function changeImage(direction) {
            if (productImages.length <= 1) return;
            
            currentImageIndex += direction;
            
            if (currentImageIndex < 0) {
                currentImageIndex = productImages.length - 1;
            } else if (currentImageIndex >= productImages.length) {
                currentImageIndex = 0;
            }
            
            updateMainImage();
        }

        function setImage(index) {
            if (index >= 0 && index < productImages.length) {
                currentImageIndex = index;
                updateMainImage();
            }
        }

        function updateMainImage() {
            const imgElement = document.getElementById('mainProductImage');
            if (imgElement && productImages.length > 0) {
                imgElement.src = productImages[currentImageIndex];
            }
        }
    </script>
</body>
</html>
