<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Produk - CampusMarket</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body { background: #f5f5f5; }
        .product-image-wrapper { height: 220px; }
        @media (max-width: 768px) { .product-image-wrapper { height: 160px; } }
        input[type="search"]::-webkit-search-cancel-button { display: none; }
        input[type="search"]::-ms-clear { display: none; }
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
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                        </span>
                        <input id="catalogSearch" type="search" placeholder="Cari produk di CampusMarket..." class="w-full h-11 pl-12 pr-4 bg-white text-gray-900 rounded-lg border-2 border-transparent focus:border-[#ACEB02] focus:ring-0 transition-all duration-300" />
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

    <main class="max-w-7xl mx-auto py-8 px-4">
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-bold text-gray-800">Katalog Produk</h2>
                <div class="text-gray-600 font-semibold">Total Produk: <span id="catalogTotal">{{ $products->total() ?? 0 }}</span></div>
            </div>
            
            @if(session('success'))
                <div class="mb-4 p-3 rounded-lg bg-green-100 text-green-700 font-semibold">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="mb-4 p-3 rounded-lg bg-red-100 text-red-700 font-semibold">{{ session('error') }}</div>
            @endif

            <div id="productGridWrapper">
                <div id="productGrid" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-5">
                    @forelse($products as $product)
                        <div class="product-card bg-white rounded-lg border border-gray-200 overflow-hidden flex flex-col justify-between">
                            <div class="product-image-wrapper p-2">
                                @php
                                    $primaryImage = isset($product->images) ? collect($product->images)->where('is_primary', true)->first() : null;
                                    $imgSrc = $primaryImage ? asset('storage/' . $primaryImage->image_path) : null;
                                @endphp
                                @if($imgSrc)
                                    <img src="{{ $imgSrc }}" alt="{{ $product->name }}" class="w-full h-full object-contain">
                                @else
                                    <div class="w-full h-full bg-gray-100 flex items-center justify-center text-gray-500 font-semibold">Gambar Produk</div>
                                @endif
                            </div>
                            <div class="p-3">
                                <div class="font-bold text-gray-800 text-base mb-1 truncate">{{ $product->name }}</div>
                                <div class="font-semibold text-gray-900 mb-2">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                                <div class="text-sm text-gray-500 mb-3">Stok: {{ $product->stock }}</div>
                                <a href="{{ route('product.show', $product) }}" class="w-full text-center px-3 py-2 bg-gray-100 border border-gray-300 text-gray-800 rounded-md font-semibold hover:bg-gray-200 transition text-sm">Detail</a>
                            </div>
                        </div>
                    @empty
                        <div id="noProductsMessage" class="col-span-full text-center py-12 text-gray-500">Tidak ada produk untuk ditampilkan.</div>
                    @endforelse
                </div>

                <div class="mt-6 flex justify-center" id="catalogPagination">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </main>

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
            if (response && response.data && Array.isArray(response.data)) return response.data;
            if (Array.isArray(response)) return response;
            return [];
        }

        (function () {
            // New filter dropdown logic
            const filterToggleBtn = document.getElementById('filterToggleButton');
            const filterDropdown = document.getElementById('filterDropdown');

            filterToggleBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                filterDropdown.classList.toggle('hidden');
            });
            
            document.addEventListener('click', (e) => {
                if (!filterDropdown.contains(e.target) && !filterToggleBtn.contains(e.target)) {
                    filterDropdown.classList.add('hidden');
                }
            });


            // Existing catalog logic
            const input = document.getElementById('catalogSearch');
            const storeFilter = document.getElementById('storeFilter');
            const provinceFilter = document.getElementById('provinceFilter');
            const cityFilter = document.getElementById('cityFilter');
            const resetBtn = document.getElementById('resetFilters');
            const grid = document.getElementById('productGrid');
            const totalEl = document.getElementById('catalogTotal');
            const paginationWrapper = document.getElementById('catalogPagination');
            const originalPagination = paginationWrapper.innerHTML;

            async function loadProvinces() {
                try {
                    const res = await fetch('/api/wilayah/provinsi');
                    const response = await res.json();
                    const data = getDataArray(response);
                    data.forEach(item => {
                        const opt = document.createElement('option');
                        opt.value = item.name;
                        opt.dataset.code = item.code;
                        opt.textContent = item.name;
                        provinceFilter.appendChild(opt);
                    });
                } catch (e) { console.error('Failed to load provinces:', e); }
            }

            provinceFilter.addEventListener('change', async function() {
                cityFilter.innerHTML = '<option value="">Semua Kab/Kota</option>';
                if (!this.value) {
                    doSearch();
                    return;
                }
                try {
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
                } catch (e) { console.error('Failed to load cities:', e); }
                doSearch();
            });

            loadProvinces();

            async function fetchResults(q = '', store = '', province = '', city = '', page = 1) {
                grid.style.opacity = '0.5';
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
                    grid.innerHTML = '<div class="col-span-full text-center py-12 text-gray-500">Tidak ada produk yang cocok ditemukan.</div>';
                    return;
                }
                items.forEach(p => {
                    const card = `
                        <div class="product-card bg-white rounded-lg border border-gray-200 overflow-hidden flex flex-col justify-between">
                            <div class="product-image-wrapper p-2">
                                ${p.image ? `<img src="${p.image}" alt="${p.name}" class="w-full h-full object-contain">` : '<div class="w-full h-full bg-gray-100 flex items-center justify-center text-gray-500 font-semibold">Gambar Produk</div>'}
                            </div>
                            <div class="p-3">
                                <div class="font-bold text-gray-800 text-base mb-1 truncate">${p.name}</div>
                                <div class="font-semibold text-gray-900 mb-2">Rp ${Number(p.price).toLocaleString('id-ID')}</div>
                                <div class="text-sm text-gray-500 mb-3">Stok: ${p.stock}</div>
                                <a href="${p.slug}" class="w-full text-center px-3 py-2 bg-gray-100 border border-gray-300 text-gray-800 rounded-md font-semibold hover:bg-gray-200 transition text-sm">Detail</a>
                            </div>
                        </div>
                    `;
                    grid.insertAdjacentHTML('beforeend', card);
                });
            }

            function renderPagination(meta, currentQuery, currentStore, currentProvince, currentCity) {
                paginationWrapper.innerHTML = '';
                if (!meta || meta.last_page <= 1) return;

                const links = meta.links.map(link => {
                    const page = new URL(link.url || '').searchParams.get('page');
                    const isActive = link.active;
                    const isDisabled = !link.url;

                    if (link.label.includes('Previous')) {
                        return `<button data-page="${page}" class="px-3 py-1 rounded-md ${isDisabled ? 'text-gray-400' : 'text-gray-700 hover:bg-gray-200'}" ${isDisabled ? 'disabled' : ''}>‹ Prev</button>`;
                    }
                    if (link.label.includes('Next')) {
                        return `<button data-page="${page}" class="px-3 py-1 rounded-md ${isDisabled ? 'text-gray-400' : 'text-gray-700 hover:bg-gray-200'}" ${isDisabled ? 'disabled' : ''}>Next ›</button>`;
                    }
                    return `<button data-page="${page}" class="px-3 py-1 rounded-md ${isActive ? 'bg-[#01343B] text-white' : 'text-gray-700 hover:bg-gray-200'}">${link.label}</button>`;
                }).join('');

                paginationWrapper.innerHTML = `<div class="flex items-center space-x-2">${links}</div>`;
                
                paginationWrapper.querySelectorAll('button[data-page]').forEach(button => {
                    button.addEventListener('click', async () => {
                        const page = button.dataset.page;
                        const res = await fetchResults(currentQuery, currentStore, currentProvince, currentCity, page);
                        if (res) {
                            renderProducts(res.data);
                            renderPagination(res.meta, currentQuery, currentStore, currentProvince, currentCity);
                            totalEl.textContent = res.meta.total;
                        }
                    });
                });
            }

            const doSearch = debounce(async function () {
                const q = input.value.trim();
                const store = storeFilter.value.trim();
                const province = provinceFilter.value;
                const city = cityFilter.value;
                
                if (!q && !store && !province && !city) {
                    // Restore original state if all filters are cleared
                    grid.innerHTML = document.getElementById('productGrid').innerHTML; 
                     window.location.search = '';
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

            resetBtn.addEventListener('click', () => {
                input.value = '';
                storeFilter.value = '';
                provinceFilter.value = '';
                cityFilter.innerHTML = '<option value="">Semua Kab/Kota</option>';
                filterDropdown.classList.add('hidden');
                window.location.search = '';
            });

        })();
    </script>
</html>