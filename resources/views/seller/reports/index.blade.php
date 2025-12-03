<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan - Seller Panel</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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

        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 32px 24px;
        }

        /* Card Style matching dashboard */
        .card {
            background: white;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
            padding: 32px;
            max-width: 800px;
            margin: 0 auto;
        }

        .header {
            margin-bottom: 24px;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 16px;
        }

        .header h1 {
            font-size: 24px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 8px;
        }

        .header p {
            color: #6b7280;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .radio-group {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .radio-option {
            display: flex;
            align-items: flex-start;
            padding: 20px;
            border: 1px solid #d1d5db;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.2s;
            background: #fff;
        }

        .radio-option:hover {
            border-color: #01343B;
            background-color: #f0fdf4;
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .radio-option input[type="radio"] {
            margin-top: 4px;
            margin-right: 16px;
            accent-color: #01343B;
            width: 18px;
            height: 18px;
        }

        .option-content h3 {
            font-size: 16px;
            font-weight: 600;
            color: #111827;
            margin-bottom: 4px;
        }

        .option-content p {
            font-size: 14px;
            color: #6b7280;
            line-height: 1.5;
        }

        .btn-primary {
            background-color: #01343B;
            color: white;
            padding: 12px 24px;
            border-radius: 8px;
            border: none;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            width: 100%;
            transition: all 0.2s;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            box-shadow: 0 2px 4px rgba(1, 52, 59, 0.2);
        }

        .btn-primary:hover {
            background-color: #024c55;
            transform: translateY(-1px);
            box-shadow: 0 4px 6px rgba(1, 52, 59, 0.3);
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 24px;
            color: #6b7280;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            transition: color 0.2s;
        }

        .btn-back:hover {
            color: #01343B;
        }

        /* Alert Style */
        .alert-error {
            background-color: #FEF2F2;
            border: 1px solid #FECACA;
            color: #991B1B;
            padding: 16px;
            border-radius: 8px;
            margin-bottom: 24px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 12px;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
</head>
<body>
    @include('seller.navbar')

    <div class="container">
        <div style="max-width: 800px; margin: 0 auto;">
            <a href="{{ route('seller.dashboard') }}" class="btn-back">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                Kembali ke Dashboard
            </a>
            
            @if(session('error'))
            <div class="alert-error">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                {{ session('error') }}
            </div>
            @endif

            <div class="card">
                <div class="header">
                    <h1>Cetak Laporan</h1>
                    <p>Pilih jenis laporan yang ingin Anda unduh dalam format PDF.</p>
                </div>

                <form action="{{ route('seller.reports.print') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <div class="radio-group">
                            <!-- SRS-MartPlace-12 -->
                            <label class="radio-option">
                                <input type="radio" name="report_type" value="stock_desc" checked>
                                <div class="option-content">
                                    <h3>Laporan Stok Produk (Urut Stok Tertinggi)</h3>
                                    <p>Menampilkan daftar produk diurutkan berdasarkan jumlah stok terbanyak. Dilengkapi rating, kategori, dan harga.</p>
                                </div>
                            </label>

                            <!-- SRS-MartPlace-13 -->
                            <label class="radio-option">
                                <input type="radio" name="report_type" value="rating_desc">
                                <div class="option-content">
                                    <h3>Laporan Stok Produk (Urut Rating Tertinggi)</h3>
                                    <p>Menampilkan daftar produk diurutkan berdasarkan rating tertinggi. Dilengkapi stok, kategori, dan harga.</p>
                                </div>
                            </label>

                            <!-- SRS-MartPlace-14 -->
                            <label class="radio-option">
                                <input type="radio" name="report_type" value="low_stock">
                                <div class="option-content">
                                    <h3>Laporan Stok Menipis</h3>
                                    <p>Menampilkan daftar produk yang harus segera dipesan (stok < 8).</p>
                                </div>
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                        Unduh Laporan (PDF)
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
