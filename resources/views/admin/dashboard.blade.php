<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - CampusMarket</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Reuse seller dashboard UX for admin: modern cards and grid layout */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f9fafb; color: #1f2937; min-height: 100vh; }
        .navbar { background: #01343B; padding: 20px 40px; display: flex; justify-content: space-between; align-items: center; border-bottom: 3px solid #ACEB02; box-shadow: 0 2px 8px rgba(0,0,0,0.06); }
        .navbar-brand { font-size: 20px; font-weight: 700; color: #fff; }
        .nav-right { display:flex; gap:12px; align-items:center; }
        .btn { padding: 8px 12px; border-radius: 6px; font-weight: 600; border: none; cursor:pointer; background: transparent; color: #fff; border: 2px solid rgba(255,255,255,0.06); }
        .btn-primary { background: #01343B; color: #fff; border: 2px solid #01343B; }
        .btn-primary:hover { background: #024c55; }
        .btn-secondary { background: #6b7280; color: #fff; border: 2px solid #6b7280; }
        .btn-secondary:hover { background: #4b5563; }
        .container { max-width: 1280px; margin: 0 auto; padding: 32px 24px; }
        .welcome-header { margin-bottom: 32px; display:flex; justify-content:space-between; align-items:flex-end; gap: 24px; flex-wrap:wrap; }
        .welcome-text h1 { font-size: 24px; font-weight: 700; color: #111827; margin-bottom:8px; }
        .welcome-text p { color: #6b7280; font-size: 14px; }
        .report-actions { display:flex; gap: 8px; }
        .summary-grid { display:grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 24px; margin-bottom: 32px; }
        .stat-card { background: white; padding: 24px; border-radius: 12px; border: 1px solid #e5e7eb; box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
        .stat-label { color: #6b7280; font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 12px; }
        .stat-value { color: #111827; font-size: 30px; font-weight: 700; letter-spacing:-0.5px; }
        .main-grid { display:grid; grid-template-columns: 1fr 360px; gap: 24px; }
        .chart-card { background: white; border-radius:10px; border: 1px solid #e5e7eb; padding: 22px; min-height: 420px; }
        .card-title { font-size: 16px; font-weight:700; color: #111827; margin-bottom: 12px; }
        .best-sellers-card, .low-stock-card { background: white; border-radius: 12px; border: 1px solid #e5e7eb; box-shadow: 0 1px 2px rgba(0,0,0,0.05); padding: 18px; }
        .product-item { display:flex; align-items:center; gap: 12px; padding: 12px 0; border-bottom: 1px solid #f3f4f6; }
        .product-item:last-child { border-bottom:none; }
        .product-name { font-size:14px; font-weight:600; color: #374151; }
        @media (max-width: 1024px) { .main-grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    <nav class="navbar">
        <div style="display:flex; align-items:center; gap:20px;">
            <a href="{{ route('admin.dashboard') }}" class="navbar-brand">CampusMarket - Admin</a>
            <a href="{{ route('admin.dashboard') }}" class="btn" style="background:transparent; color: white; border:2px solid rgba(255,255,255,0.06); padding:6px 12px; border-radius:6px; font-weight:600; text-decoration:none;" @if(request()->routeIs('admin.dashboard')) aria-current="page" style="background: #024c55;" @endif>Dashboard</a>
            <a href="{{ route('admin.seller-registrations.index') }}" class="btn" style="background:transparent; color: white; border:2px solid rgba(255,255,255,0.06); padding:6px 12px; border-radius:6px; font-weight:600; text-decoration:none;" @if(request()->routeIs('admin.seller-registrations.*')) aria-current="page" style="background: #024c55;" @endif>Verifikasi Seller</a>
        </div>
        <div class="nav-right">
            <form action="{{ route('logout') }}" method="POST" style="display:inline-block;">
                @csrf
                <button class="btn btn-primary" type="submit">Logout</button>
            </form>
        </div>
    </nav>

    <div class="container">
        <div class="welcome-header">
            <div class="welcome-text">
                <h1>Dashboard Overview</h1>
                <p>Ringkasan performa platform & laporan cepat. Selamat datang, {{ Auth::user()->name }}.</p>
            </div>
            <div class="report-actions">
                <a href="{{ route('admin.seller-registrations.index') }}" class="btn btn-secondary">Verifikasi Seller</a>
                <button id="downloadSellersReport" class="btn btn-primary">Download Sellers Report (PDF)</button>
                <button id="downloadLocationsReport" class="btn btn-primary">Download Location Report (PDF)</button>
                <button id="downloadTopProductsReport" class="btn btn-primary">Download Top Products (PDF)</button>
            </div>
        </div>

        <div class="summary-grid">
            <div class="stat-card">
                <div class="stat-label">Total Products</div>
                <div class="stat-value" id="totalProducts">-</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Total Sellers</div>
                <div class="stat-value" id="totalSellers">-</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Active Sellers</div>
                <div class="stat-value" id="activeSellers">-</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Unique Reviewers</div>
                <div class="stat-value" id="uniqueReviewers">-</div>
            </div>
        </div>

        <div class="main-grid">
            <div>
                <div class="chart-card">
                    <div class="chart-header-row" style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
                        <div>
                            <div class="card-title">Products by Category</div>
                            <p style="color:#6b7280; font-size:13px;">Sebaran produk berdasarkan kategori.</p>
                        </div>
                        <div>
                            <select id="categoryFilter">
                                <option value="">Semua Kategori</option>
                            </select>
                        </div>
                    </div>
                    <div style="height:270px;">
                        <canvas id="chartCategory"></canvas>
                    </div>
                </div>
                <div class="chart-card" style="margin-top: 20px;">
                    <div class="chart-header-row">
                        <div>
                            <div class="card-title">Sellers by Province</div>
                            <p style="color:#6b7280; font-size:13px;">Distribusi seller berdasarkan provinsi.</p>
                        </div>
                    </div>
                    <div style="height:270px;">
                        <canvas id="chartProvince"></canvas>
                    </div>
                </div>
                <div class="chart-card" style="margin-top: 20px;">
                    <div class="chart-header-row">
                        <div>
                            <div class="card-title">Active vs Inactive Sellers</div>
                        </div>
                    </div>
                    <div style="height:220px;">
                        <canvas id="chartActive"></canvas>
                    </div>
                </div>
            </div>
            <div>
                <div class="best-sellers-card">
                    <div class="card-title">Top Rated Products</div>
                    <div id="topProductsList" style="overflow:auto; max-height:360px;">
                        <!-- populated via JS -->
                    </div>
                </div>
                <div class="low-stock-card" style="margin-top:20px;">
                    <div class="card-title">Low Stock Alerts</div>
                    <div id="lowStockList"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        async function fetchOverview() {
            const res = await fetch('/api/admin/dashboard/overview');
            if (!res.ok) throw new Error('fail');
            return res.json();
        }

        async function fetchCategoryDistribution() {
            const res = await fetch('/api/admin/dashboard/product-category-distribution');
            return res.ok ? res.json() : { labels: [], data: [] };
        }

        async function fetchLowStock() {
            const res = await fetch('/api/admin/dashboard/low-stock');
            return res.ok ? res.json() : { products: [] };
        }

        async function fetchSellersByProvince() {
            const res = await fetch('/api/admin/dashboard/sellers-by-province');
            return res.ok ? res.json() : { labels: [], data: [] };
        }

        async function fetchSellerStatusComparison() {
            const res = await fetch('/api/admin/dashboard/seller-status-comparison');
            return res.ok ? res.json() : { labels: [], data: [] };
        }

        async function fetchTopProducts() {
            const res = await fetch('/api/admin/reports/top-products?limit=10');
            return res.ok ? res.json() : { products: [] };
        }

        function renderChart(ctx, type, data, options) {
            return new Chart(ctx, { type, data, options });
        }

        document.addEventListener('DOMContentLoaded', async () => {
            function formatNumber(n) { return n?.toLocaleString ? n.toLocaleString() : n; }
            try {
                const overview = await fetchOverview();
                document.getElementById('totalProducts').textContent = formatNumber(overview.total_products);
                document.getElementById('totalSellers').textContent = formatNumber(overview.total_sellers);
                document.getElementById('activeSellers').textContent = formatNumber(overview.active_sellers);

                const reviewers = await fetch('/api/admin/dashboard/reviewers-count').then(r => r.json());
                document.getElementById('uniqueReviewers').textContent = reviewers.unique_reviewers;

                const cat = await fetchCategoryDistribution();
                let categoryChart = renderChart(document.getElementById('chartCategory'), 'doughnut', { labels: cat.labels, datasets: [{ data: cat.data, backgroundColor: ['#4ECDC4', '#FF6B6B', '#FFD166', '#74C0F5', '#9B5DE5', '#06D6A0', '#F25F5C', '#3A86FF'] }] }, {});
                // if no data, replace with friendly message
                if (!cat.labels || (cat.data && cat.data.reduce((a,b)=>a+b,0) === 0)) {
                    const wrapper = document.getElementById('chartCategory').parentElement;
                    wrapper.innerHTML = '<div style="display:flex;align-items:center;justify-content:center;height:100%;color:#6b7280;">No data available</div>';
                }

                // Populate and attach category select
                const categoryFilter = document.getElementById('categoryFilter');
                cat.labels.forEach(lbl => {
                    const opt = document.createElement('option');
                    opt.value = lbl; opt.textContent = lbl; categoryFilter.appendChild(opt);
                });
                categoryFilter.addEventListener('change', () => {
                    const val = categoryFilter.value;
                    if (!val) {
                        categoryChart.destroy();
                        categoryChart = renderChart(document.getElementById('chartCategory'), 'doughnut', { labels: cat.labels, datasets: [{ data: cat.data, backgroundColor: ['#4ECDC4', '#FF6B6B', '#FFD166', '#74C0F5', '#9B5DE5', '#06D6A0', '#F25F5C', '#3A86FF'] }] }, {});
                        return;
                    }
                    // Filter to chosen category
                    const idx = cat.labels.indexOf(val);
                    if (idx >= 0) {
                        const labels = [cat.labels[idx]];
                        const data = [cat.data[idx]];
                        categoryChart.destroy();
                        categoryChart = renderChart(document.getElementById('chartCategory'), 'doughnut', { labels: labels, datasets: [{ data: data, backgroundColor: ['#4ECDC4'] }] }, {});
                    }
                });

                const prov = await fetchSellersByProvince();
                if (!prov.labels || (prov.data && prov.data.reduce((a,b)=>a+b,0) === 0)) {
                    document.getElementById('chartProvince').parentElement.innerHTML = '<div style="display:flex;align-items:center;justify-content:center;height:100%;color:#6b7280;">No data available</div>';
                } else {
                    renderChart(document.getElementById('chartProvince'), 'bar', { labels: prov.labels, datasets: [{ label: 'Sellers', data: prov.data, backgroundColor:'#74C0F5' }] }, {});
                }

                const status = await fetchSellerStatusComparison();
                if (!status.labels || (status.data && status.data.reduce((a,b)=>a+b,0) === 0)) {
                    document.getElementById('chartActive').parentElement.innerHTML = '<div style="display:flex;align-items:center;justify-content:center;height:100%;color:#6b7280;">No data available</div>';
                } else {
                    renderChart(document.getElementById('chartActive'), 'pie', { labels: status.labels, datasets: [{ data: status.data, backgroundColor:['#8BE3B9', '#FFD1A6'] }] }, {});
                }

                const top = await fetchTopProducts();
                const list = document.getElementById('topProductsList');
                top.products.forEach(p => {
                    const el = document.createElement('div');
                    el.style.padding = '8px 4px';
                    el.style.borderBottom = '1px solid #eee';
                    el.innerHTML = `<strong>${p.name}</strong> - ${p.store_name || '-'} <span style='float:right;'>${(p.avg_rating || 0).toFixed(2)} ★</span>`;
                    list.appendChild(el);
                });

                // low stock list
                const low = await fetchLowStock();
                const lowList = document.getElementById('lowStockList');
                if (low.products && low.products.length) {
                    low.products.slice(0, 6).forEach(p => {
                        const el = document.createElement('div');
                        el.className = 'product-item';
                        el.innerHTML = `<div style="flex:1;"><div class='product-name'>${p.name}</div><div style='color:#6b7280; font-size:12px;'>Stock: ${p.stock}</div></div>`;
                        lowList.appendChild(el);
                    });
                } else {
                    lowList.innerHTML = '<p style="color:#6b7280;">No low stock alerts</p>';
                }

            } catch (err) {
                console.error('Error loading admin dashboard', err);
            }

            // Report buttons: trigger JSON request (placeholder for PDF)
            document.getElementById('downloadSellersReport').addEventListener('click', async () => {
                window.open('/api/admin/reports/sellers?format=pdf', '_blank');
            });
            document.getElementById('downloadLocationsReport').addEventListener('click', async () => {
                window.open('/api/admin/reports/locations?format=pdf', '_blank');
            });
            document.getElementById('downloadTopProductsReport').addEventListener('click', async () => {
                window.open('/api/admin/reports/top-products?limit=50&format=pdf', '_blank');
            });
        });
    </script>
</body>
</html>
