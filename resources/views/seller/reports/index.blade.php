<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan - Seller Panel</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f9fafb;
            color: #1f2937;
        }
        .container {
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
        }
        .card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            padding: 32px;
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
        }
        .form-group {
            margin-bottom: 20px;
        }
        .radio-group {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        .radio-option {
            display: flex;
            align-items: flex-start;
            padding: 16px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s;
        }
        .radio-option:hover {
            border-color: #01343B;
            background-color: #f0fdf4;
        }
        .radio-option input[type="radio"] {
            margin-top: 4px;
            margin-right: 12px;
        }
        .option-content h3 {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 4px;
        }
        .option-content p {
            font-size: 14px;
            color: #6b7280;
        }
        .btn-primary {
            background-color: #01343B;
            color: white;
            padding: 12px 24px;
            border-radius: 8px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
            margin-top: 24px;
            transition: background-color 0.2s;
        }
        .btn-primary:hover {
            background-color: #024c55;
        }
        .btn-back {
            display: inline-block;
            margin-bottom: 20px;
            color: #6b7280;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
        }
        .btn-back:hover {
            color: #111827;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="{{ route('seller.dashboard') }}" class="btn-back">← Kembali ke Dashboard</a>
        
        @if(session('error'))
        <div style="background-color: #fee2e2; border: 1px solid #ef4444; color: #b91c1c; padding: 12px; border-radius: 8px; margin-bottom: 20px;">
            {{ session('error') }}
        </div>
        @endif

        <div class="card">
            <div class="header">
                <h1>Cetak Laporan</h1>
                <p style="color: #6b7280; margin-top: 4px;">Pilih jenis laporan yang ingin Anda cetak.</p>
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

                <button type="submit" class="btn-primary">Cetak Laporan (PDF)</button>
            </form>
        </div>
    </div>
</body>
</html>
