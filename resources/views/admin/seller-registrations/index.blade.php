<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Verifikasi Seller</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: white;
            min-height: 100vh;
        }
        
        .navbar {
            background: #01343B;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 3px solid #ACEB02;
        }
        
        .navbar-brand {
            font-size: 20px;
            font-weight: 600;
            color: white;
        }
        
        .btn-logout {
            background: transparent;
            border: 2px solid white;
            color: white;
            padding: 8px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.2s;
        }
        
        .btn-logout:hover {
            background: white;
            color: #01343B;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
        }
        
        .page-header {
            margin-bottom: 30px;
        }
        
        .page-header h1 {
            color: #01343B;
            font-size: 28px;
            margin-bottom: 8px;
        }
        
        .page-header p {
            color: #666;
            font-size: 14px;
        }
        
        .alert {
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }
        
        .alert-success {
            background-color: #d4edda;
            border-left: 4px solid #28a745;
            color: #155724;
        }
        
        .alert-error {
            background-color: #f8d7da;
            border-left: 4px solid #dc3545;
            color: #721c24;
        }
        
        .table-container {
            background: white;
            border: 1px solid #e1e1e1;
            border-radius: 8px;
            overflow: hidden;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        th {
            background: #f8f9fa;
            color: #01343B;
            padding: 15px 20px;
            text-align: left;
            font-weight: 600;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #e1e1e1;
        }
        
        td {
            padding: 15px 20px;
            border-bottom: 1px solid #e1e1e1;
            color: #333;
            font-size: 14px;
        }
        
        tbody tr:hover {
            background: #f8f9fa;
        }
        
        tbody tr:last-child td {
            border-bottom: none;
        }
        
        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .badge-pending {
            background: #FFF9E6;
            color: #856404;
            border: 1px solid #FFE69C;
        }
        
        .badge-approved {
            background: #E8F5E9;
            color: #155724;
            border: 1px solid #C3E6CB;
        }
        
        .badge-rejected {
            background: #FFEBEE;
            color: #721c24;
            border: 1px solid #F5C6CB;
        }
        
        .btn {
            padding: 8px 16px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: all 0.2s;
            font-size: 13px;
        }
        
        .btn-detail {
            background: #01343B;
            color: white;
        }
        
        .btn-detail:hover {
            background: #023840;
            transform: translateY(-1px);
        }
        
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #999;
        }
        
        .pagination {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            gap: 5px;
        }
        
        .filter-section {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .filter-section label {
            color: #01343B;
            font-weight: 600;
            font-size: 14px;
        }
        
        .filter-section select {
            padding: 8px 12px;
            border: 2px solid #e1e1e1;
            border-radius: 6px;
            font-size: 14px;
            min-width: 200px;
            cursor: pointer;
        }
        
        .filter-section select:focus {
            outline: none;
            border-color: #01343B;
        }
        
        .btn-filter {
            background: #01343B;
            color: white;
            padding: 8px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.2s;
        }
        
        .btn-filter:hover {
            background: #023840;
        }
        
        .btn-reset {
            background: #6c757d;
            color: white;
            padding: 8px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn-reset:hover {
            background: #5a6268;
        }
        
        .btn-delete {
            background: #dc3545;
            color: white;
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
            transition: all 0.2s;
            margin-left: 5px;
        }
        
        .btn-delete:hover {
            background: #c82333;
        }
        
        .action-buttons {
            display: flex;
            gap: 5px;
            align-items: center;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="navbar-brand">Admin Panel - CampusMarket</div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn-logout">Logout</button>
        </form>
    </nav>

    <div class="container">
        <div class="page-header">
            <h1>Verifikasi Registrasi Seller</h1>
            <p>Kelola dan verifikasi pendaftaran seller yang masuk</p>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif

        <div class="filter-section">
            <form method="GET" action="{{ route('admin.seller-registrations.index') }}" style="display: flex; align-items: center; gap: 15px; width: 100%;">
                <label for="status">Filter Status:</label>
                <select name="status" id="status">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
                <button type="submit" class="btn-filter">Filter</button>
                <a href="{{ route('admin.seller-registrations.index') }}" class="btn-reset">Reset</a>
            </form>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Nama Toko</th>
                        <th>Nama PIC</th>
                        <th>Email</th>
                        <th>No HP</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($registrations as $registration)
                        <tr>
                            <td>{{ $registration->created_at->format('d/m/Y H:i') }}</td>
                            <td><strong>{{ $registration->nama_toko }}</strong></td>
                            <td>{{ $registration->nama_pic }}</td>
                            <td>{{ $registration->email_pic }}</td>
                            <td>{{ $registration->no_hp_pic }}</td>
                            <td>
                                @if ($registration->status === 'pending')
                                    <span class="badge badge-pending">Pending</span>
                                @elseif ($registration->status === 'approved')
                                    <span class="badge badge-approved">Approved</span>
                                @else
                                    <span class="badge badge-rejected">Rejected</span>
                                @endif
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('admin.seller-registrations.show', $registration->id) }}" class="btn btn-detail">
                                        Lihat Detail
                                    </a>
                                    <form action="{{ route('admin.seller-registrations.destroy', $registration->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data seller ini? Data yang sudah dihapus tidak dapat dikembalikan.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-delete">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="empty-state">
                                Belum ada registrasi seller
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            @if($registrations->hasPages())
                <div class="pagination">
                    {{ $registrations->links() }}
                </div>
            @endif
        </div>
    </div>
</body>
</html>
