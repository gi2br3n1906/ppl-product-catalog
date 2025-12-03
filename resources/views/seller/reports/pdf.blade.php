<!DOCTYPE html>
<html>
<head>
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .meta {
            margin-bottom: 20px;
        }
        .store-info {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>{{ $title }}</h2>
    </div>

    <div class="meta">
        <div class="store-info">Toko: {{ $seller->name }}</div>
        <div>Tanggal Cetak: {{ now()->format('d F Y H:i') }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 35%;">Nama Produk</th>
                <th style="width: 20%;">Kategori</th>
                <th style="width: 20%;">Harga</th>
                <th style="width: 10%;">Stok</th>
                <th style="width: 10%;">Rating</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $index => $product)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->category }}</td>
                <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                <td style="text-align: center;">{{ $product->stock }}</td>
                <td style="text-align: center;">{{ number_format($product->reviews_avg_rating ?? 0, 1) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center;">Tidak ada data produk.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
