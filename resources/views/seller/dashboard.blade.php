<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard Seller</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', 'Segoe UI', sans-serif;
            background-color: #f9fafb;
            color: #1f2937;
            min-height: 100vh;
        }
        
        /* Navbar */
        .navbar {
            background: #01343B;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 3px solid #ACEB02;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .navbar-brand {
            font-size: 20px;
            font-weight: 600;
            color: white;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .btn-logout {
            background: transparent;
            border: 2px solid white;
            color: white;
            padding: 8px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.2s;
        }
        
        .btn-logout:hover {
            background: white;
            color: #01343B;
            border-color: white;
        }
        
        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 32px 24px;
        }
        
        /* Welcome Section */
        .welcome-header {
            margin-bottom: 32px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            gap: 24px;
            flex-wrap: wrap;
        }
        
        .welcome-text {
            flex: 1;
            min-width: 300px;
        }

        .welcome-text h1 {
            font-size: 24px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 8px;
        }
        
        .welcome-text p {
            color: #6b7280;
            font-size: 14px;
        }

        .btn-primary {
            background-color: #01343B;
            color: white;
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
            border: none;
            box-shadow: 0 2px 4px rgba(1, 52, 59, 0.2);
            white-space: nowrap;
        }

        .btn-primary:hover {
            background-color: #024c55;
            transform: translateY(-1px);
            box-shadow: 0 4px 6px rgba(1, 52, 59, 0.3);
        }

        /* Stats Grid (Top) */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 24px;
            margin-bottom: 32px;
        }

        .stat-card {
            background: white;
            padding: 24px;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
            transition: transform 0.2s;
        }
        
        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .stat-label {
            color: #6b7280;
            font-size: 13px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 12px;
        }

        .stat-value {
            color: #111827;
            font-size: 30px;
            font-weight: 700;
            letter-spacing: -0.5px;
        }
        
        .stat-trend {
            display: flex;
            align-items: center;
            gap: 4px;
            margin-top: 8px;
            font-size: 12px;
            font-weight: 500;
        }
        
        .stat-trend.positive { color: #059669; }
        .stat-trend.neutral { color: #6b7280; }

        /* Main Layout Grid */
        .main-grid {
            display: grid;
            grid-template-columns: 1fr 320px;
            gap: 24px;
        }

        /* Chart Section */
        .chart-card {
            background: white;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
            padding: 24px;
            min-height: 500px;
            min-width: 0; /* PENTING: Mencegah grid blowout */
        }

        .chart-header-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            flex-wrap: wrap;
            gap: 16px;
        }

        .chart-tabs {
            display: flex;
            background: #f3f4f6;
            padding: 4px;
            border-radius: 8px;
        }

        .chart-tab {
            padding: 8px 16px;
            border: none;
            background: transparent;
            color: #6b7280;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            border-radius: 6px;
            transition: all 0.2s;
        }

        .chart-tab.active {
            background: white;
            color: #111827;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        }

        .chart-controls {
            display: flex;
            gap: 12px;
        }

        select {
            padding: 8px 12px;
            border-radius: 6px;
            border: 1px solid #d1d5db;
            background-color: white;
            color: #374151;
            font-size: 13px;
            cursor: pointer;
            outline: none;
        }
        
        select:focus {
            border-color: #01343B;
            ring: 2px solid rgba(1, 52, 59, 0.1);
        }

        /* Best Sellers Section */
        .best-sellers-card {
            background: white;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
            padding: 24px;
            height: fit-content;
        }

        .card-title {
            font-size: 16px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 20px;
        }

        .product-item {
            display: flex;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #f3f4f6;
        }
        
        .product-item:last-child {
            border-bottom: none;
        }

        .rank-badge {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: #f3f4f6;
            color: #6b7280;
            font-size: 12px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
        }
        
        .rank-badge.top-1 { background: #FEF3C7; color: #D97706; }
        .rank-badge.top-2 { background: #E5E7EB; color: #374151; }
        .rank-badge.top-3 { background: #FFEDD5; color: #C2410C; }

        .product-details {
            flex: 1;
        }

        .product-name {
            font-size: 14px;
            font-weight: 600;
            color: #374151;
            display: block;
            margin-bottom: 2px;
        }

        .product-stat {
            font-size: 12px;
            color: #6b7280;
        }

        /* Loading & Chart Area */
        .chart-canvas-container {
            position: relative;
            height: 400px;
            width: 100%;
            min-width: 0; /* PENTING: Mencegah overflow */
        }

        /* Custom Scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            height: 12px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }

        .loading-state {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            color: #6b7280;
            width: 100%;
            z-index: 10;
        }
        
        .spinner {
            border: 3px solid #f3f3f3;
            border-top: 3px solid #01343B;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            animation: spin 1s linear infinite;
            margin: 0 auto 10px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .main-grid {
                grid-template-columns: 1fr;
            }
            
            .chart-header-row {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .chart-tabs {
                width: 100%;
                overflow-x: auto;
            }
            
            .chart-tab {
                white-space: nowrap;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="navbar-brand">CampusMarket - Seller Panel</div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn-logout">Logout</button>
        </form>
    </nav>

    <div class="container">
        <!-- Welcome Header -->
        <div class="welcome-header">
            <div class="welcome-text">
                <h1>Dashboard Overview</h1>
                <p>Selamat datang kembali, {{ Auth::user()->name }}. Berikut adalah ringkasan performa toko Anda.</p>
            </div>
            <a href="{{ route('seller.kelola-produk') }}" class="btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="7" width="18" height="13" rx="2" ry="2"></rect>
                    <path d="M16 3v4M8 3v4M3 11h18"></path>
                </svg>
                Kelola Produk
            </a>
        </div>

        <!-- Top Stats Grid -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-label">Total Penjualan (Bulan Ini)</div>
                <div class="stat-value">Rp 8.500.000</div>
                <div class="stat-trend positive">
                    <span>↗ 12%</span> dari bulan lalu
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Produk Terjual</div>
                <div class="stat-value">142</div>
                <div class="stat-trend positive">
                    <span>↗ 5%</span> dari bulan lalu
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Pesanan Pending</div>
                <div class="stat-value">8</div>
                <div class="stat-trend neutral">
                    <span>-</span> Perlu diproses
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Rating Toko</div>
                <div class="stat-value">4.8</div>
                <div class="stat-trend positive">
                    <span>★</span> Dari 5.0
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="main-grid">
            <!-- Left: Chart Section -->
            <div class="chart-card">
                <div class="chart-header-row">
                    <div class="chart-tabs">
                        <button class="chart-tab active" data-chart="sales">Penjualan</button>
                        <button class="chart-tab" data-chart="stock">Stok</button>
                        <button class="chart-tab" data-chart="rating">Rating</button>
                        <button class="chart-tab" data-chart="location">Lokasi</button>
                    </div>
                    
                    <div class="chart-controls">
                        <div id="yearSelector" class="selector-group">
                            <select id="yearSelect"></select>
                        </div>
                        <div id="productSelector" class="selector-group" style="display: none;">
                            <select id="productSelect">
                                <option value="">Semua Produk</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="chart-canvas-container">
                    <div class="loading-state">
                        <div class="spinner"></div>
                        <p>Memuat data...</p>
                    </div>
                    
                    <!-- Wrapper untuk scroll -->
                    <div id="chartScrollContainer" class="custom-scrollbar" style="width: 100%; height: 100%; overflow-x: auto; overflow-y: hidden; display: none;">
                        <div id="chartWidthContainer" style="height: 100%; position: relative;">
                            <canvas id="dynamicChart"></canvas>
                        </div>
                    </div>

                    <img id="dummyChartImage" alt="Chart Placeholder" style="display: none; max-width: 100%; max-height: 100%; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                </div>
                
                <!-- Total Sales Display for Sales Chart -->
                <div id="totalSalesDisplay" style="margin-top: 20px; text-align: center; display: none;">
                    <span style="color: #6b7280; font-size: 14px;">Total Tahun Ini:</span>
                    <span class="total-value" style="font-weight: 700; color: #01343B; font-size: 18px;">Rp 0</span>
                </div>
            </div>

            <!-- Right: Best Sellers & Low Stock -->
            <div class="right-column">
                <!-- Best Sellers -->
                <div class="best-sellers-card">
                    <h3 class="card-title">Produk Terlaris 🔥</h3>
                    <div class="product-list">
                        <div class="product-item">
                            <div class="rank-badge top-1">1</div>
                            <div class="product-details">
                                <span class="product-name">Buku Tulis Spiral A5</span>
                                <span class="product-stat">89 terjual</span>
                            </div>
                        </div>
                        <div class="product-item">
                            <div class="rank-badge top-2">2</div>
                            <div class="product-details">
                                <span class="product-name">Pulpen Hitam 0.5mm</span>
                                <span class="product-stat">76 terjual</span>
                            </div>
                        </div>
                        <div class="product-item">
                            <div class="rank-badge top-3">3</div>
                            <div class="product-details">
                                <span class="product-name">Pensil 2B (Pack 12)</span>
                                <span class="product-stat">52 terjual</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Low Stock Alert -->
                <div class="low-stock-card" style="margin-top: 24px; background: white; border-radius: 12px; border: 1px solid #e5e7eb; padding: 24px; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                    <h3 class="card-title" style="color: #DC2626; display: flex; align-items: center; gap: 8px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                        Stok Menipis
                    </h3>
                    <div id="lowStockList" class="product-list">
                        <!-- Content will be loaded via JS -->
                        <div class="loading-state-small" style="text-align: center; padding: 20px; color: #6b7280;">
                            Memuat data...
                        </div>
                    </div>
                    <div id="safeStockState" style="display: none; text-align: center; padding: 20px;">
                        <div style="background: #ECFDF5; width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 12px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#059669" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                        </div>
                        <h4 style="font-weight: 600; color: #059669; margin-bottom: 4px;">Aman Terkendali!</h4>
                        <p style="font-size: 13px; color: #6b7280;">Stok Anda terpantau aman.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Inisialisasi Chart.js
        let myChart = null;
        let currentChartType = 'sales';
        let productsData = [];
        let yearsData = [];
        let currentYear = new Date().getFullYear();
        
        // Konfigurasi chart berdasarkan tipe
        const chartConfigs = {
            sales: {
                type: 'bar',
                title: 'Total Penjualan Bulanan',
                backgroundColor: 'rgba(172, 235, 2, 0.6)',
                borderColor: 'rgba(172, 235, 2, 1)',
                yAxisLabel: 'Penjualan (Rp)'
            },
            stock: {
                type: 'bar',
                title: 'Sebaran Jumlah Stok Produk',
                backgroundColor: 'rgba(1, 52, 59, 0.6)',
                borderColor: 'rgba(1, 52, 59, 1)',
                yAxisLabel: 'Jumlah Stok'
            },
            rating: {
                type: 'line',
                title: 'Sebaran Nilai Rating Produk',
                backgroundColor: 'rgba(255, 215, 0, 0.2)',
                borderColor: 'rgba(255, 215, 0, 1)',
                yAxisLabel: 'Rating (1-5)'
            },
            location: {
                type: 'doughnut',
                title: 'Sebaran Lokasi Pemberi Rating',
                backgroundColor: [
                    'rgba(172, 235, 2, 0.8)',
                    'rgba(1, 52, 59, 0.8)',
                    'rgba(255, 193, 7, 0.8)',
                    'rgba(220, 53, 69, 0.8)',
                    'rgba(13, 110, 253, 0.8)',
                    'rgba(111, 66, 193, 0.8)'
                ],
                borderColor: 'rgba(255, 255, 255, 1)',
                yAxisLabel: 'Jumlah Rating'
            }
        };
        
        /**
         * Fungsi untuk render chart atau gambar dummy
         */
        function renderChart(chartType, labels, data, hasData, dummyImageUrl, total = null) {
            const canvas = document.getElementById('dynamicChart');
            const scrollContainer = document.getElementById('chartScrollContainer');
            const widthContainer = document.getElementById('chartWidthContainer');
            const dummyImage = document.getElementById('dummyChartImage');
            const loadingState = document.querySelector('.loading-state');
            const totalSalesDisplay = document.getElementById('totalSalesDisplay');
            
            // Update total penjualan jika ada
            if (chartType === 'sales' && total !== null) {
                const formattedTotal = new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                }).format(total);
                
                totalSalesDisplay.style.display = 'block';
                totalSalesDisplay.querySelector('.total-value').textContent = formattedTotal;
            } else {
                totalSalesDisplay.style.display = 'none';
            }
            
            // Sembunyikan loading
            loadingState.style.display = 'none';
            
            // Hancurkan chart sebelumnya jika ada
            if (myChart) {
                myChart.destroy();
                myChart = null;
            }
            
            if (hasData) {
                // Tampilkan container chart
                scrollContainer.style.display = 'block';
                canvas.style.display = 'block';
                dummyImage.style.display = 'none';
                
                // Reset styles
                scrollContainer.style.overflowX = 'hidden';
                widthContainer.style.width = '100%';
                
                // Logika Scroll Horizontal
                if (chartType === 'stock' || chartType === 'rating') {
                    const totalItems = labels.length;
                    // Ubah itemsPerView jadi 12 (mirip chart penjualan yg 12 bulan)
                    const itemsPerView = 12; 
                    
                    if (totalItems > itemsPerView) {
                        // Aktifkan scroll
                        scrollContainer.style.overflowX = 'auto';
                        
                        // Hitung lebar container
                        // Gunakan getBoundingClientRect untuk akurasi lebih tinggi
                        const visibleWidth = scrollContainer.parentElement.getBoundingClientRect().width;
                        
                        if (visibleWidth > 0) {
                            // Hitung lebar total yang dibutuhkan
                            // Kita kecilkan minItemWidth jadi 80px (sebelumnya 150px terlalu lebar)
                            const minItemWidth = 80; 
                            const calculatedWidth = (totalItems / itemsPerView) * visibleWidth;
                            const minTotalWidth = totalItems * minItemWidth;
                            
                            // Gunakan yang lebih besar agar tidak terlalu sempit
                            // Tapi prioritas tetap proporsional view jika memungkinkan
                            const finalWidth = Math.max(calculatedWidth, minTotalWidth);
                            
                            widthContainer.style.width = `${finalWidth}px`;
                        } else {
                            // Fallback jika width tidak terdeteksi
                            widthContainer.style.width = `${totalItems * 80}px`;
                        }
                    } else {
                        widthContainer.style.width = '100%';
                        scrollContainer.style.overflowX = 'hidden';
                    }
                } else {
                    widthContainer.style.width = '100%';
                    scrollContainer.style.overflowX = 'hidden';
                }
                
                const config = chartConfigs[chartType];
                
                // Custom Color Logic untuk Stock < 8
                let datasetBackgroundColor = config.backgroundColor;
                let datasetBorderColor = config.borderColor;

                if (chartType === 'stock') {
                    datasetBackgroundColor = data.map(val => val < 8 ? 'rgba(220, 53, 69, 0.8)' : config.backgroundColor);
                    datasetBorderColor = data.map(val => val < 8 ? 'rgba(220, 53, 69, 1)' : config.borderColor);
                }
                
                // Konfigurasi Chart.js
                const chartConfig = {
                    type: config.type,
                    data: {
                        labels: labels,
                        datasets: [{
                            label: config.title,
                            data: data,
                            backgroundColor: datasetBackgroundColor,
                            borderColor: datasetBorderColor,
                            borderWidth: 2,
                            tension: 0.4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: config.type === 'doughnut',
                                position: 'bottom'
                            },
                            title: {
                                display: false
                            }
                        }
                    }
                };
                
                // Tambahkan konfigurasi scales untuk chart non-doughnut
                if (config.type !== 'doughnut') {
                    chartConfig.options.scales = {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: config.yAxisLabel
                            }
                        }
                    };
                }
                
                // Inisialisasi Chart.js
                myChart = new Chart(canvas, chartConfig);
            } else {
                // Tampilkan dummy image, sembunyikan canvas
                scrollContainer.style.display = 'none';
                canvas.style.display = 'none';
                dummyImage.style.display = 'block';
                dummyImage.src = dummyImageUrl;
            }
        }
        
        /**
         * Fungsi untuk load data dari API
         */
        function loadChartData(chartType, productId = null, year = null) {
            currentChartType = chartType;
            
            const canvas = document.getElementById('dynamicChart');
            const scrollContainer = document.getElementById('chartScrollContainer');
            const dummyImage = document.getElementById('dummyChartImage');
            const loadingState = document.querySelector('.loading-state');
            const productSelector = document.getElementById('productSelector');
            const yearSelector = document.getElementById('yearSelector');
            const totalSalesDisplay = document.getElementById('totalSalesDisplay');
            
            // Show/hide selectors berdasarkan chart type
            if (chartType === 'sales') {
                yearSelector.style.display = 'block';
                productSelector.style.display = 'none';
            } else if (chartType === 'location') {
                productSelector.style.display = 'block';
                yearSelector.style.display = 'none';
            } else {
                productSelector.style.display = 'none';
                yearSelector.style.display = 'none';
            }
            
            // Tampilkan loading
            if (scrollContainer) scrollContainer.style.display = 'none';
            canvas.style.display = 'none';
            dummyImage.style.display = 'none';
            totalSalesDisplay.style.display = 'none';
            loadingState.style.display = 'block';
            
            let apiUrl = `/api/dashboard/${chartType}`;
            const params = [];
            
            // Tambahkan parameter year untuk chart sales
            if (chartType === 'sales' && year) {
                params.push(`year=${year}`);
            }
            
            // Tambahkan parameter product_id untuk chart location
            if (chartType === 'location' && productId) {
                params.push(`product_id=${productId}`);
            }
            
            if (params.length > 0) {
                apiUrl += `?${params.join('&')}`;
            }
            
            const dummyImageUrl = `/images/dummy_charts/dummy_${chartType}_chart.svg`;
            
            // Fetch data dari API
            fetch(apiUrl, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(jsonData => {
                renderChart(
                    chartType,
                    jsonData.labels,
                    jsonData.data,
                    jsonData.hasData,
                    dummyImageUrl,
                    jsonData.total || null
                );
            })
            .catch(error => {
                console.error('Error fetching chart data:', error);
                // Jika error, tampilkan dummy image
                renderChart(chartType, [], [], false, dummyImageUrl, null);
            });
        }
        
        /**
         * Fungsi untuk load daftar produk
         */
        function loadProducts() {
            fetch('/api/dashboard/products', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                productsData = data.products;
                const productSelect = document.getElementById('productSelect');
                
                // Clear existing options except "Semua Produk"
                productSelect.innerHTML = '<option value="">Semua Produk</option>';
                
                // Tambahkan opsi produk
                productsData.forEach(product => {
                    const option = document.createElement('option');
                    option.value = product.id;
                    option.textContent = product.name;
                    productSelect.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error fetching products:', error);
            });
        }
        
        /**
         * Fungsi untuk load daftar tahun
         */
        function loadYears() {
            fetch('/api/dashboard/years', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                yearsData = data.years;
                currentYear = data.current_year;
                const yearSelect = document.getElementById('yearSelect');
                
                // Clear existing options
                yearSelect.innerHTML = '';
                
                // Tambahkan opsi tahun (prioritas tahun terkini)
                yearsData.forEach(year => {
                    const option = document.createElement('option');
                    option.value = year;
                    option.textContent = year;
                    if (year === currentYear) {
                        option.selected = true;
                    }
                    yearSelect.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error fetching years:', error);
            });
        }
        
        /**
         * Event listener untuk tombol navigasi
         */
        document.addEventListener('DOMContentLoaded', function() {
            const chartTabs = document.querySelectorAll('.chart-tab');
            const productSelect = document.getElementById('productSelect');
            const yearSelect = document.getElementById('yearSelect');
            
            // Load daftar produk dan tahun saat halaman dimuat
            loadProducts();
            loadYears();
            
            chartTabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    // Hapus class active dari semua tombol
                    chartTabs.forEach(t => t.classList.remove('active'));
                    
                    // Tambahkan class active ke tombol yang diklik
                    this.classList.add('active');
                    
                    // Ambil data-chart attribute
                    const chartType = this.getAttribute('data-chart');
                    
                    // Reset dropdowns
                    if (chartType === 'sales') {
                        // Set ke tahun saat ini
                        yearSelect.value = currentYear;
                        loadChartData(chartType, null, currentYear);
                    } else if (chartType === 'location') {
                        productSelect.value = '';
                        loadChartData(chartType);
                    } else {
                        loadChartData(chartType);
                    }
                });
            });
            
            // Event listener untuk dropdown produk
            productSelect.addEventListener('change', function() {
                const selectedProductId = this.value;
                // Reload chart location dengan produk yang dipilih
                if (currentChartType === 'location') {
                    loadChartData('location', selectedProductId);
                }
            });
            
            // Event listener untuk dropdown tahun
            yearSelect.addEventListener('change', function() {
                const selectedYear = this.value;
                // Reload chart sales dengan tahun yang dipilih
                if (currentChartType === 'sales') {
                    loadChartData('sales', null, selectedYear);
                }
            });
            
            // Load chart default (sales) dengan tahun saat ini saat halaman pertama kali dimuat
            // Tunggu sebentar untuk memastikan dropdown tahun sudah terisi
            setTimeout(() => {
                loadChartData('sales', null, currentYear);
                loadLowStockProducts(); // Load data stok menipis
            }, 100);
        });

        /**
         * Fungsi untuk load produk stok menipis
         */
        function loadLowStockProducts() {
            const listContainer = document.getElementById('lowStockList');
            const safeState = document.getElementById('safeStockState');
            
            fetch('/api/dashboard/low-stock', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                const products = data.products;
                listContainer.innerHTML = ''; // Clear loading state
                
                if (products.length > 0) {
                    safeState.style.display = 'none';
                    listContainer.style.display = 'block';
                    
                    products.forEach(product => {
                        const itemHtml = `
                            <div class="product-item" style="border-left: 3px solid #DC2626; padding-left: 12px;">
                                <div class="product-details">
                                    <span class="product-name" style="color: #1f2937;">${product.name}</span>
                                    <span class="product-stat" style="color: #DC2626; font-weight: 600;">Sisa: ${product.stock} unit</span>
                                </div>
                                <a href="{{ route('seller.kelola-produk') }}" style="font-size: 12px; color: #01343B; text-decoration: none; font-weight: 600; background: #f3f4f6; padding: 4px 8px; border-radius: 4px;">Kelola Produk</a>
                            </div>
                        `;
                        listContainer.insertAdjacentHTML('beforeend', itemHtml);
                    });
                } else {
                    listContainer.style.display = 'none';
                    safeState.style.display = 'block';
                }
            })
            .catch(error => {
                console.error('Error fetching low stock products:', error);
                listContainer.innerHTML = '<p style="text-align: center; color: #DC2626;">Gagal memuat data.</p>';
            });
        }
    </script>
</body>
</html>
