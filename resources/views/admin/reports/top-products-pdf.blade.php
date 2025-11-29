<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Top Products Report</title>
    <style>
        /* Avoid CSS variables; dompdf doesn't support them well */
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size:12px; color:#222; margin:0; background: #fff; }
        header { background: #01343B; color: white; padding: 12px 18px; display:flex; justify-content:space-between; align-items:center; }
        header h1 { font-size: 18px; margin:0; }
        .container { padding: 12px 18px; }
        table { width: 100%; border-collapse: collapse; margin-top:6px; }
        th, td { border: 1px solid #e6e6e6; padding:10px; }
        th { background: #ACEB02; color: #01343B; text-align:left; font-size:12px; font-weight:700; }
        footer { position: fixed; bottom: 0; left: 0; right: 0; height: 24px; padding: 6px 18px; font-size:10px; color:#666; display:flex; justify-content:space-between; align-items:center; border-top: 1px solid #e6e6e6; }
    </style>
 </head>
 <body>
    <header>
        <div class="brand">CampusMarket</div>
        <div class="meta">Generated: {{ now() }}</div>
    </header>
    <div class="container">
        <h2>Top Products Report</h2>
    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Store</th>
                <th>Category</th>
                <th>Price</th>
                <th>Province</th>
                <th>Avg Rating</th>
                <th>Total Reviews</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $p)
            <tr>
                <td>{{ $p->name }}</td>
                <td>{{ $p->store_name }}</td>
                <td>{{ $p->category }}</td>
                <td>{{ number_format($p->price, 2, ',', '.') }}</td>
                <td>{{ $p->provinsi ?? '-' }}</td>
                <td>{{ round($p->avg_rating ?? 0, 2) }}</td>
                <td>{{ $p->total_reviews ?? 0 }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>
    <footer>
        <div>CampusMarket - Product Catalog</div>
        <div class="page-number">Page <span class="page">{PAGE_NUM}</span> of <span class="pages">{PAGE_COUNT}</span></div>
    </footer>
    <script type="text/php">
        if (isset($pdf)) {
            $text = "Page {PAGE_NUM} of {PAGE_COUNT}";
            $size = 10;
            $font = $fontMetrics->get_font("Helvetica", "normal");
            $pdf->page_text(520, 820, $text, $font, $size, array(0,0,0));
        }
    </script>
 </body>
 </html>
