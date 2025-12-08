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

        /* btn-buy removed: buying flow disabled for now */
        
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
    
    <style>
        /* Hide the native clear button for input type="search" */
        input[type="search"]::-webkit-search-cancel-button {
            -webkit-appearance: none; /* Remove default styling for WebKit browsers */
            display: none; /* Hide the button */
        }

        input[type="search"]::-ms-clear {
            display: none; /* Hide the button for Internet Explorer/Edge */
        }

        /* Also remove default 'x' button for Firefox (though it's less common for Firefox to have one by default) */
        input[type="search"] {
            -moz-appearance: none;
            -webkit-appearance: none; /* For consistency across Webkit browsers */
            appearance: none;
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
                <a href="{{ route('seller.register.form') }}" class="btn-register">Daftar Seller</a>
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

            <!-- Filter dan Pencarian -->
            <div style="background: white; padding: 20px; border-radius: 12px; margin-bottom: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.06);">
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 15px;">
                    <!-- Pencarian Produk -->
                    <div style="position:relative;">
                        <label style="display: block; font-size: 12px; color: #666; margin-bottom: 5px; font-weight: 600;">Cari Produk</label>
                        <span style="position:absolute; left: 12px; top: 35px; color: #999; z-index: 2;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                        </span>
                        <input id="catalogSearch" type="search" placeholder="Nama produk..." style="padding: 8px 30px 8px 35px; border: 1px solid #ddd; border-radius: 8px; width: 100%; font-size: 14px;" />
                        <button id="clearSearch" style="position:absolute; right:10px; top:35px; background:transparent; border:none; cursor:pointer; color:#999; font-size: 18px; display: none; z-index: 2;">✕</button>
                    </div>

                    <!-- Filter Nama Toko -->
                    <div>
                        <label style="display: block; font-size: 12px; color: #666; margin-bottom: 5px; font-weight: 600;">Nama Toko</label>
                        <input id="storeFilter" type="text" placeholder="Cari nama toko..." style="padding: 8px 12px; border: 1px solid #ddd; border-radius: 8px; width: 100%; font-size: 14px;" />
                    </div>

                    <!-- Filter Provinsi -->
                    <div>
                        <label style="display: block; font-size: 12px; color: #666; margin-bottom: 5px; font-weight: 600;">Provinsi</label>
                        <select id="provinceFilter" style="padding: 8px 12px; border: 1px solid #ddd; border-radius: 8px; width: 100%; font-size: 14px;">
                            <option value="">Semua Provinsi</option>
                        </select>
                    </div>

                    <!-- Filter Kabupaten/Kota -->
                    <div>
                        <label style="display: block; font-size: 12px; color: #666; margin-bottom: 5px; font-weight: 600;">Kabupaten/Kota</label>
                        <select id="cityFilter" style="padding: 8px 12px; border: 1px solid #ddd; border-radius: 8px; width: 100%; font-size: 14px;">
                            <option value="">Semua Kab/Kota</option>
                        </select>
                    </div>
                </div>

                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <button id="resetFilters" style="padding: 8px 16px; background: #6b7280; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 14px; font-weight: 600;">Reset Filter</button>
                    <div style="color:#666; font-weight: 600;">Total Produk: <span id="catalogTotal">{{ $products->total() ?? 0 }}</span></div>
                </div>
            </div>

            <div id="productGridWrapper">
                <div id="productGrid" class="product-grid" style="display:grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 20px;">
                    @forelse($products as $product)
                        <div class="product-card" style="background: white; padding: 16px; border-radius: 8px; border: 1px solid #e9e9e9;">
                            <div class="product-image-wrapper">
                                @php
                                    $primaryImage = isset($product->images) ? collect($product->images)->where('is_primary', true)->first() : null;
                                    $imgSrc = $primaryImage ? asset('storage/' . $primaryImage->image_path) : null;
                                @endphp
                                @if($imgSrc)
                                    <img src="{{ $imgSrc }}" alt="{{ $product->name }}">
                                @else
                                    <div style="display:flex;align-items:center;justify-content:center; width:100%; height:100%; background:#f0f0f0; color:#999; font-weight:600;">
                                        Gambar Produk
                                    </div>
                                @endif
                            </div>
                            <div style="font-weight:700; color:#01343B; margin-bottom:4px;">{{ $product->name }}</div>
                            <div style="font-weight:600; color:#234; margin-bottom:8px;">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                            <div style="font-size:12px; color:#666; margin-bottom:12px;">Stok: {{ $product->stock }}</div>

                            <div style="display:flex; gap:8px;">
                                <a href="{{ route('product.show', $product) }}" class="btn-product-action" style="flex:1;">Detail</a>
                            </div>
                        </div>
                    @empty
                        <div id="noProductsMessage">Tidak ada produk untuk ditampilkan.</div>
                    @endforelse
                </div>

                <div style="margin-top:20px; display:flex; justify-content:center; gap:8px; align-items:center;" id="catalogPagination">
                    {{ $products->links() }}
                </div>
            </div>

            <div style="margin-top:20px; display:flex; justify-content:center;">
                {{ $products->links() }}
            </div>
        </div>
    </div>

    {{-- Buy flow (autopost after login) removed — only product detail display for now --}}
</body>
    <script>
        // Simple debounce helper
        function debounce(fn, wait) {
            let t;
            return function (...args) {
                clearTimeout(t);
                t = setTimeout(() => fn.apply(this, args), wait);
            };
        }

        // Helper function untuk mengambil data dari response API
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

        (function () {
            const input = document.getElementById('catalogSearch');
            const storeFilter = document.getElementById('storeFilter');
            const provinceFilter = document.getElementById('provinceFilter');
            const cityFilter = document.getElementById('cityFilter');
            const resetBtn = document.getElementById('resetFilters');
            const clearBtn = document.getElementById('clearSearch');
            const grid = document.getElementById('productGrid');
            const totalEl = document.getElementById('catalogTotal');
            const paginationWrapper = document.getElementById('catalogPagination');

            // Load provinces
            async function loadProvinces() {
                try {
                    const res = await fetch('/api/wilayah/provinsi');
                    const response = await res.json();
                    const data = getDataArray(response);
                    data.forEach(item => {
                        const opt = document.createElement('option');
                        opt.value = item.name;
                        opt.dataset.code = item.code; // Simpan code untuk fetch kabupaten
                        opt.textContent = item.name;
                        provinceFilter.appendChild(opt);
                    });
                } catch (e) {
                    console.error('Failed to load provinces:', e);
                }
            }

            // Load cities when province changes
            provinceFilter.addEventListener('change', async function() {
                cityFilter.innerHTML = '<option value="">Semua Kab/Kota</option>';
                if (!this.value) {
                    doSearch();
                    return;
                }
                
                try {
                    // Get province code from selected option
                    const selectedOption = provinceFilter.options[provinceFilter.selectedIndex];
                    const provinceCode = selectedOption.dataset.code;
                    
                    if (provinceCode) {
                        const res = await fetch(`/api/wilayah/kabupaten?provinsi_id=${provinceCode}`);
                        const response = await res.json();
                        const data = getDataArray(response);
                        data.forEach(item => {
                            const opt = document.createElement('option');
                            opt.value = item.name;
                            opt.textContent = item.name;
                            cityFilter.appendChild(opt);
                        });
                    }
                } catch (e) {
                    console.error('Failed to load cities:', e);
                }
                
                doSearch();
            });

            // Load initial data
            loadProvinces();

            // Show/hide clear button
            input.addEventListener('input', () => {
                clearBtn.style.display = input.value.trim() ? 'block' : 'none';
            });

            async function fetchResults(q = '', store = '', province = '', city = '', page = 1) {
                grid.style.opacity = '0.5'; // Loading indicator
                const url = new URL(window.location.origin + '/api/products/search');
                if (q) url.searchParams.set('q', q);
                if (store) url.searchParams.set('store', store);
                if (province) url.searchParams.set('province', province);
                if (city) url.searchParams.set('city', city);
                url.searchParams.set('page', page);
                url.searchParams.set('per_page', 12);

                try {
                    const res = await fetch(url.toString());
                    if (!res.ok) return null;
                    return res.json();
                } finally {
                    grid.style.opacity = '1';
                }
            }

            function renderProducts(items) {
                grid.innerHTML = '';
                if (!items || items.length === 0) {
                    grid.innerHTML = '<div id="noProductsMessage" style="grid-column: 1 / -1; text-align:center; padding: 40px 0; color: #777;">Tidak ada produk yang cocok ditemukan.</div>';
                    return;
                }
                items.forEach(p => {
                    const card = document.createElement('div');
                    card.className = 'product-card';
                    card.style = 'background: white; padding: 16px; border-radius: 8px; border: 1px solid #e9e9e9;';

                    const imgWrap = document.createElement('div');
                    imgWrap.className = 'product-image-wrapper';
                    if (p.image) {
                        const img = document.createElement('img');
                        img.src = p.image; img.alt = p.name;
                        imgWrap.appendChild(img);
                    } else {
                        const placeholder = document.createElement('div');
                        placeholder.style = 'display:flex;align-items:center;justify-content:center; width:100%; height:100%; background:#f0f0f0; color:#999; font-weight:600;';
                        placeholder.textContent = 'Gambar Produk';
                        imgWrap.appendChild(placeholder);
                    }

                    const name = document.createElement('div'); name.style = 'font-weight:700; color:#01343B; margin-bottom:4px;'; name.textContent = p.name;
                    const price = document.createElement('div'); price.style = 'font-weight:600; color:#234; margin-bottom:8px;'; price.textContent = 'Rp ' + Number(p.price).toLocaleString('id-ID');
                    const stock = document.createElement('div'); stock.style = 'font-size:12px; color:#666; margin-bottom:12px;'; stock.textContent = 'Stok: ' + p.stock;

                    const actions = document.createElement('div'); actions.style = 'display:flex; gap:8px;';
                    const detail = document.createElement('a'); detail.href = p.slug; detail.className = 'btn-product-action'; detail.style.flex = '1'; detail.textContent = 'Detail';
                    actions.appendChild(detail);

                    card.appendChild(imgWrap);
                    card.appendChild(name);
                    card.appendChild(price);
                    card.appendChild(stock);
                    card.appendChild(actions);

                    grid.appendChild(card);
                });
            }

            function renderPagination(meta, currentQuery, currentStore, currentProvince, currentCity) {
                paginationWrapper.innerHTML = '';
                if (!meta || meta.last_page <= 1) {
                    paginationWrapper.style.display = 'none';
                    return;
                }
                paginationWrapper.style.display = 'flex';

                const prevBtn = document.createElement('button'); prevBtn.textContent = '‹ Prev'; prevBtn.className = 'btn-product-action';
                const nextBtn = document.createElement('button'); nextBtn.textContent = 'Next ›'; nextBtn.className = 'btn-product-action';
                prevBtn.disabled = meta.current_page <= 1; nextBtn.disabled = meta.current_page >= meta.last_page;
                
                prevBtn.style.opacity = prevBtn.disabled ? '0.6' : '1';
                nextBtn.style.opacity = nextBtn.disabled ? '0.6' : '1';

                prevBtn.addEventListener('click', async () => {
                    const res = await fetchResults(currentQuery, currentStore, currentProvince, currentCity, meta.current_page - 1);
                    if (res) { renderProducts(res.data); renderPagination(res.meta, currentQuery, currentStore, currentProvince, currentCity); totalEl.textContent = res.meta.total; }
                });
                nextBtn.addEventListener('click', async () => {
                    const res = await fetchResults(currentQuery, currentStore, currentProvince, currentCity, meta.current_page + 1);
                    if (res) { renderProducts(res.data); renderPagination(res.meta, currentQuery, currentStore, currentProvince, currentCity); totalEl.textContent = res.meta.total; }
                });

                const info = document.createElement('div'); info.style = 'color:#666; padding:6px 10px;'; info.textContent = `Hal ${meta.current_page} dari ${meta.last_page}`;
                paginationWrapper.appendChild(prevBtn);
                paginationWrapper.appendChild(info);
                paginationWrapper.appendChild(nextBtn);
            }

            const doSearch = debounce(async function () {
                const q = input.value.trim();
                const store = storeFilter.value.trim();
                const province = provinceFilter.value;
                const city = cityFilter.value;
                
                if (!q && !store && !province && !city) {
                    window.location.search = ''; // Simple reload to restore original server-rendered content
                    return;
                }
                const res = await fetchResults(q, store, province, city, 1);
                if (res) {
                    renderProducts(res.data);
                    renderPagination(res.meta, q, store, province, city);
                    totalEl.textContent = res.meta.total;
                }
            }, 350);

            input.addEventListener('input', doSearch);
            storeFilter.addEventListener('input', debounce(doSearch, 500));
            cityFilter.addEventListener('change', doSearch);
            
            clearBtn.addEventListener('click', () => {
                input.value = '';
                clearBtn.style.display = 'none';
                doSearch();
            });

            resetBtn.addEventListener('click', () => {
                input.value = '';
                storeFilter.value = '';
                provinceFilter.value = '';
                cityFilter.innerHTML = '<option value="">Semua Kab/Kota</option>';
                clearBtn.style.display = 'none';
                window.location.search = '';
            });

            // Initially hide the JS pagination wrapper
            paginationWrapper.style.display = 'none';

        })();
    </script>