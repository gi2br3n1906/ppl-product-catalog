<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Sellers Report</title>
    <style>
        /* Application theme-based styles */
        /* Theme colors (avoid CSS variables for Dompdf) */
        /* Primary dark: #01343B, primary light: #ACEB02, muted: #666666, accent: #74C0F5 */
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size:12px; color:#222; margin:0; background: #fff; }
        header { background: #01343B; color: #fff; padding: 12px 18px; display:flex; justify-content:space-between; align-items:center; }
        header h1 { font-size: 18px; margin:0; letter-spacing: 0.2px; }
        header .meta { font-size: 11px; opacity: 0.95; }
        .brand { font-weight:700; }
        .container { padding: 12px 18px; }
        table { width: 100%; border-collapse: collapse; margin-top:6px; }
        th, td { border: 1px solid #e6e6e6; padding:10px; }
        th { background: #ACEB02; color: #01343B; text-align:left; font-size:12px; font-weight:700; }
        tbody tr:nth-child(odd) { background: #ffffff; }
        tbody tr:nth-child(even) { background: #fbfbfb; }
        h2 { color: var(--primary-dark); margin:0 0 6px 0; }
        footer { position: fixed; bottom: 0; left: 0; right: 0; height: 24px; padding: 6px 18px; font-size:10px; color:#666; display:flex; justify-content:space-between; align-items:center; border-top: 1px solid #e6e6e6; }
        .page-number { text-align:right; width:100%; }
    </style>
 </head>
 <body>
    <header>
        <div class="brand">CampusMarket</div>
        <div class="meta">Generated: {{ now() }}</div>
    </header>
    <div class="container">
        <h2>Sellers Report</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Store</th>
                <th>PIC</th>
                <th>Email</th>
                <th>Province</th>
                <th>Status</th>
                <th>Registered</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sellers as $s)
            <tr>
                <td>{{ $s->id }}</td>
                <td>{{ $s->nama_toko }}</td>
                <td>{{ $s->nama_pic }}</td>
                <td>{{ $s->email_pic }}</td>
                <td>{{ $s->provinsi }}</td>
                <td>{{ ucfirst($s->status) }}</td>
                <td>{{ \Carbon\Carbon::parse($s->created_at)->format('d/m/Y H:i') }}</td>
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
