<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} - Detail Produk</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body { background: #f5f5f5; }
        
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
<body class="antialiased font-sans">
    <nav class="bg-[#01343B] shadow-md sticky top-0 z-30">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex items-center justify-between h-20 gap-4">
                <!-- Brand -->
                <div class="flex-shrink-0">
                    <a href="{{ route('catalog') }}" class="text-white text-xl font-bold">CampusMarket</a>
                </div>

                <!-- Middle Section: Filter + Search -->
                <div class="flex-grow flex items-center justify-center gap-3">
                    <!-- Filter Button -->
                    <div class="relative flex-shrink-0">
                        <button id="filterToggleButton" class="h-11 px-4 flex items-center bg-white/10 hover:bg-white/20 rounded-lg text-sm font-semibold text-white transition">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                            Filter
                        </button>
                    </div>

                    <!-- Search Bar -->
                    <div class="relative flex-grow max-w-xl">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 z-10">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                        </span>
                        <input id="catalogSearch" type="search" placeholder="Cari produk di CampusMarket..." class="w-full h-11 pl-12 pr-4 bg-white text-gray-900 rounded-lg border-2 border-transparent focus:border-[#ACEB02] focus:ring-0 transition-all duration-300" />
                        
                        <!-- Search Results Dropdown -->
                        <div id="searchResultsDropdown" class="hidden absolute top-full mt-2 left-0 right-0 bg-white shadow-lg border border-gray-200 rounded-lg z-50 max-h-96 overflow-y-auto">
                            <div id="searchResultsContent" class="p-4">
                                <!-- Search results will be populated here -->
                            </div>
                        </div>
                    </div>
                </div>

                <!-- User Auth -->
                <div class="flex-shrink-0 flex items-center space-x-4">
                    @auth
                        <div class="text-white hidden md:block">
                            Halo, {{ Auth::user()->name }}!
                        </div>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-transparent border-2 border-white text-white rounded-md font-semibold hover:bg-white hover:text-[#01343B] transition">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 bg-[#ACEB02] text-[#01343B] rounded-md font-semibold hover:bg-[#9dd302] transition">Login</a>
                        <a href="{{ route('seller.register.form') }}" class="px-4 py-2 bg-[#ACEB02] text-[#01343B] rounded-md font-semibold hover:bg-[#9dd302] transition hidden sm:flex">Daftar Seller</a>
                    @endauth
                </div>
            </div>
        </div>
        
        <!-- Filter Dropdown -->
        <div id="filterDropdown" class="hidden absolute top-full left-0 right-0 bg-white shadow-lg border-t border-gray-200 z-20">
            <div class="max-w-7xl mx-auto p-4">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Toko</label>
                        <input id="storeFilter" type="text" placeholder="Cari nama toko..." class="w-full border-gray-300 rounded-md shadow-sm text-sm" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Provinsi</label>
                        <select id="provinceFilter" class="w-full border-gray-300 rounded-md shadow-sm text-sm">
                            <option value="">Semua Provinsi</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kabupaten/Kota</label>
                        <select id="cityFilter" class="w-full border-gray-300 rounded-md shadow-sm text-sm">
                            <option value="">Semua Kab/Kota</option>
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button id="resetFilters" class="w-full px-4 py-2 bg-gray-600 text-white rounded-md font-semibold hover:bg-gray-700 transition text-sm">Reset Filter</button>
                    </div>
                </div>
            </div>
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
            const phoneInput = document.getElementById('reviewer_phone');
            
            // Validasi input nomor HP hanya angka
            phoneInput.addEventListener('input', function(e) {
                // Hapus karakter selain angka
                this.value = this.value.replace(/[^0-9]/g, '');
            });
            
            // Cegah input karakter non-angka saat mengetik
            phoneInput.addEventListener('keypress', function(e) {
                // Izinkan: backspace, delete, tab, escape, enter
                if ([8, 9, 27, 13].indexOf(e.keyCode) !== -1 ||
                    // Izinkan: Ctrl+A, Ctrl+C, Ctrl+V, Ctrl+X
                    (e.keyCode === 65 && e.ctrlKey === true) ||
                    (e.keyCode === 67 && e.ctrlKey === true) ||
                    (e.keyCode === 86 && e.ctrlKey === true) ||
                    (e.keyCode === 88 && e.ctrlKey === true)) {
                    return;
                }
                // Pastikan hanya angka yang diketik
                if ((e.keyCode < 48 || e.keyCode > 57)) {
                    e.preventDefault();
                }
            });
            
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

        // Filter dropdown toggle
        const filterToggleBtn = document.getElementById('filterToggleButton');
        const filterDropdown = document.getElementById('filterDropdown');

        if (filterToggleBtn && filterDropdown) {
            filterToggleBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                filterDropdown.classList.toggle('hidden');
                // Close search dropdown when filter opens
                searchResultsDropdown.classList.add('hidden');
            });
            
            document.addEventListener('click', (e) => {
                if (!filterDropdown.contains(e.target) && !filterToggleBtn.contains(e.target)) {
                    filterDropdown.classList.add('hidden');
                }
            });
        }

        // Search functionality with dropdown
        const searchInput = document.getElementById('catalogSearch');
        const searchResultsDropdown = document.getElementById('searchResultsDropdown');
        const searchResultsContent = document.getElementById('searchResultsContent');
        let searchTimeout;

        if (searchInput) {
            searchInput.addEventListener('input', (e) => {
                const query = e.target.value.trim();
                
                // Bersihkan timeout sebelumnya
                clearTimeout(searchTimeout);
                
                if (query.length === 0) {
                    searchResultsDropdown.classList.add('hidden');
                    return;
                }
                
                // Debounce search - tunggu 300ms setelah user berhenti mengetik
                searchTimeout = setTimeout(() => {
                    performSearch(query);
                }, 300);
            });
            
            // Close search dropdown when clicking outside
            document.addEventListener('click', (e) => {
                if (!searchInput.contains(e.target) && !searchResultsDropdown.contains(e.target)) {
                    searchResultsDropdown.classList.add('hidden');
                }
            });
        }

        async function performSearch(query) {
            try {
                searchResultsContent.innerHTML = '<div class="text-center text-gray-500 py-4">Mencari...</div>';
                searchResultsDropdown.classList.remove('hidden');
                
                const response = await fetch(`/api/products/search?q=${encodeURIComponent(query)}&per_page=10`);
                const data = await response.json();
                
                if (data.data && data.data.length > 0) {
                    renderSearchResults(data.data);
                } else {
                    searchResultsContent.innerHTML = '<div class="text-center text-gray-500 py-4">Tidak ada produk ditemukan</div>';
                }
            } catch (error) {
                console.error('Search error:', error);
                searchResultsContent.innerHTML = '<div class="text-center text-red-500 py-4">Terjadi kesalahan saat mencari</div>';
            }
        }

        function renderSearchResults(products) {
            let html = '<div class="grid grid-cols-1 gap-3">';
            
            products.forEach(product => {
                const rating = product.average_rating || 0;
                const reviewsCount = product.reviews_count || 0;
                
                html += `
                    <a href="${product.slug}" class="flex gap-3 p-3 hover:bg-gray-50 rounded-lg transition border border-gray-100">
                        <div class="flex-shrink-0 w-20 h-20 bg-gray-100 rounded-lg overflow-hidden">
                            ${product.image ? `<img src="${product.image}" alt="${product.name}" class="w-full h-full object-cover">` : '<div class="w-full h-full flex items-center justify-center text-xs text-gray-400">No Image</div>'}
                        </div>
                        <div class="flex-grow min-w-0">
                            <div class="font-semibold text-gray-800 text-sm truncate">${product.name}</div>
                            <div class="font-bold text-gray-900 text-base">Rp ${Number(product.price).toLocaleString('id-ID')}</div>
                            <div class="flex items-center gap-1 mt-1">
                                <svg class="w-3 h-3 text-yellow-400 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                                <span class="text-xs text-gray-700">${rating.toFixed(1)}</span>
                                <span class="text-xs text-gray-500">(${reviewsCount})</span>
                                <span class="text-xs text-gray-500 ml-2">Stok: ${product.stock}</span>
                            </div>
                        </div>
                    </a>
                `;
            });
            
            html += '</div>';
            html += `<div class="mt-3 pt-3 border-t border-gray-200"><a href="{{ route('catalog') }}" class="block text-center text-sm text-[#01343B] font-semibold hover:underline">Lihat Semua Hasil →</a></div>`;
            
            searchResultsContent.innerHTML = html;
        }

        // Reset filters button - redirect to catalog
        const resetBtn = document.getElementById('resetFilters');
        if (resetBtn) {
            resetBtn.addEventListener('click', () => {
                window.location.href = `{{ route('catalog') }}`;
            });
        }
    </script>
</body>
</html>
