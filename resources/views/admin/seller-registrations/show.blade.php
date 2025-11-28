<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Registrasi Seller</title>
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
            max-width: 1000px;
            margin: 0 auto;
            padding: 40px 20px;
        }
        
        .back-button {
            display: inline-block;
            margin-bottom: 20px;
            color: #01343B;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
        }
        
        .back-button:hover {
            text-decoration: underline;
        }
        
        .page-header {
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .page-header h1 {
            color: #01343B;
            font-size: 28px;
        }
        
        .badge {
            display: inline-block;
            padding: 6px 16px;
            border-radius: 4px;
            font-size: 13px;
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
        
        .detail-card {
            background: white;
            border: 1px solid #e1e1e1;
            border-radius: 8px;
            padding: 30px;
            margin-bottom: 20px;
        }
        
        .section-title {
            color: #01343B;
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 20px;
            padding-bottom: 10px;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
            margin-bottom: 20px;
        }
        
        .info-item {
            display: flex;
            flex-direction: column;
        }
        
        .info-label {
            color: #666;
            font-size: 12px;
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .info-value {
            color: #333;
            font-size: 15px;
            font-weight: 500;
        }
        
        .document-preview {
            margin-top: 10px;
            border: 1px solid #e1e1e1;
            border-radius: 8px;
            overflow: hidden;
            max-width: 100%;
        }
        
        .document-preview img {
            width: 100%;
            height: auto;
            display: block;
        }
        
        .action-buttons {
            display: flex;
            gap: 15px;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e1e1e1;
        }
        
        .btn {
            padding: 10px 24px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.2s;
        }
        
        .btn-approve {
            background: #ACEB02;
            color: #01343B;
            flex: 1;
        }
        
        .btn-approve:hover {
            background: #9DD802;
        }
        
        .btn-reject {
            background: #dc3545;
            color: white;
            flex: 1;
        }
        
        .btn-reject:hover {
            background: #c82333;
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

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }
        
        .modal-content {
            background-color: white;
            margin: 10% auto;
            padding: 0;
            border-radius: 8px;
            width: 90%;
            max-width: 500px;
        }
        
        .modal-header {
            padding: 20px 25px;
            border-bottom: 1px solid #e1e1e1;
        }
        
        .modal-header h2 {
            color: #01343B;
            font-size: 20px;
            margin: 0;
        }
        
        .modal-body {
            padding: 25px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            color: #333;
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 14px;
        }
        
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #e1e1e1;
            border-radius: 6px;
            font-family: inherit;
            font-size: 14px;
            min-height: 120px;
            resize: vertical;
        }
        
        .form-group textarea:focus {
            outline: none;
            border-color: #01343B;
        }
        
        .modal-buttons {
            display: flex;
            gap: 10px;
            padding: 20px 25px;
            border-top: 1px solid #e1e1e1;
        }
        
        .btn-modal {
            flex: 1;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.2s;
        }
        
        .btn-modal-cancel {
            background: #f8f9fa;
            color: #333;
        }
        
        .btn-modal-cancel:hover {
            background: #e9ecef;
        }
        
        .btn-modal-submit {
            background: #dc3545;
            color: white;
        }
        
        .btn-modal-submit:hover {
            background: #c82333;
        }

        @media (max-width: 768px) {
            .info-grid {
                grid-template-columns: 1fr;
            }
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
        <a href="{{ route('admin.seller-registrations.index') }}" class="back-button">← Kembali ke Daftar</a>

        <div class="page-header">
            <h1>Detail Registrasi Seller</h1>
            @if ($registration->status === 'pending')
                <span class="badge badge-pending">Pending</span>
            @elseif ($registration->status === 'approved')
                <span class="badge badge-approved">Approved</span>
            @else
                <span class="badge badge-rejected">Rejected</span>
            @endif
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

        <div class="detail-card">
            <!-- Data Toko -->
            <div class="section-title">Data Toko</div>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Nama Toko</div>
                    <div class="info-value">{{ $registration->nama_toko }}</div>
                </div>
                <div class="info-item" style="grid-column: 1 / -1;">
                    <div class="info-label">Deskripsi Singkat</div>
                    <div class="info-value">{{ $registration->deskripsi_singkat }}</div>
                </div>
            </div>

            <!-- Data PIC -->
            <div class="section-title">Data Person In Charge (PIC)</div>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Nama Lengkap</div>
                    <div class="info-value">{{ $registration->nama_pic }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">No KTP</div>
                    <div class="info-value">{{ $registration->no_ktp_pic }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Email</div>
                    <div class="info-value">{{ $registration->email_pic }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">No HP</div>
                    <div class="info-value">{{ $registration->no_hp_pic }}</div>
                </div>
            </div>

            <!-- Alamat -->
            <div class="section-title">Alamat PIC</div>
            <div class="info-grid">
                <div class="info-item" style="grid-column: 1 / -1;">
                    <div class="info-label">Jalan</div>
                    <div class="info-value">{{ $registration->jalan }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">RT</div>
                    <div class="info-value">{{ $registration->rt }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">RW</div>
                    <div class="info-value">{{ $registration->rw }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Kelurahan</div>
                    <div class="info-value">{{ $registration->kelurahan }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Kabupaten/Kota</div>
                    <div class="info-value">{{ $registration->kab_kota }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Provinsi</div>
                    <div class="info-value">{{ $registration->provinsi }}</div>
                </div>
            </div>

            <!-- Dokumen -->
            <div class="section-title">Dokumen</div>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Foto PIC</div>
                    @if ($registration->foto_pic)
                        <div class="document-preview">
                            <img src="{{ asset('storage/' . $registration->foto_pic) }}" alt="Foto PIC">
                        </div>
                    @else
                        <div class="info-value">Tidak ada foto</div>
                    @endif
                </div>
                <div class="info-item">
                    <div class="info-label">KTP/Identitas</div>
                    @if ($registration->file_ktp)
                        <div class="document-preview">
                            @if (str_ends_with($registration->file_ktp, '.pdf'))
                                <a href="{{ asset('storage/' . $registration->file_ktp) }}" target="_blank" style="display: block; padding: 20px; text-align: center; background: #f8f9fa; color: #01343B; text-decoration: none; font-weight: 600;">
                                    Lihat Dokumen PDF
                                </a>
                            @else
                                <img src="{{ asset('storage/' . $registration->file_ktp) }}" alt="KTP">
                            @endif
                        </div>
                    @else
                        <div class="info-value">Tidak ada dokumen</div>
                    @endif
                </div>
            </div>

            <!-- Info Tanggal -->
            <div class="section-title">Informasi Pendaftaran</div>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Tanggal Daftar</div>
                    <div class="info-value">{{ $registration->created_at->format('d F Y, H:i') }} WIB</div>
                </div>
                @if ($registration->verified_at)
                    <div class="info-item">
                        <div class="info-label">Tanggal Verifikasi</div>
                        <div class="info-value">{{ $registration->verified_at->format('d F Y, H:i') }} WIB</div>
                    </div>
                @endif
            </div>

            @if ($registration->status === 'rejected' && $registration->rejection_reason)
                <div class="section-title">Alasan Penolakan</div>
                <div class="info-item">
                    <div class="info-value" style="color: #721c24;">{{ $registration->rejection_reason }}</div>
                </div>
            @endif

            @if ($registration->verifiedBy)
                <div class="section-title">Diverifikasi Oleh</div>
                <div class="info-item">
                    <div class="info-value">{{ $registration->verifiedBy->name }}</div>
                </div>
            @endif

            <!-- Action Buttons -->
            @if ($registration->status === 'pending')
                <div class="action-buttons">
                    <form action="{{ route('admin.seller-registrations.approve', $registration->id) }}" method="POST" style="flex: 1;">
                        @csrf
                        <button type="submit" class="btn btn-approve" style="width: 100%;" onclick="return confirm('Apakah Anda yakin ingin menyetujui registrasi ini?')">
                            Setujui Pendaftaran
                        </button>
                    </form>
                    
                    <button type="button" class="btn btn-reject" style="flex: 1;" onclick="openRejectModal()">
                        Tolak Pendaftaran
                    </button>
                </div>
            @endif
        </div>
    </div>

    <!-- Modal Reject -->
    <div id="rejectModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Tolak Pendaftaran</h2>
            </div>
            <form action="{{ route('admin.seller-registrations.reject', $registration->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="rejection_reason">Alasan Penolakan <span style="color: red;">*</span></label>
                        <textarea 
                            id="rejection_reason" 
                            name="rejection_reason" 
                            placeholder="Jelaskan alasan penolakan registrasi ini..."
                            required
                        ></textarea>
                    </div>
                </div>
                <div class="modal-buttons">
                    <button type="button" class="btn-modal btn-modal-cancel" onclick="closeRejectModal()">Batal</button>
                    <button type="submit" class="btn-modal btn-modal-submit">Tolak Pendaftaran</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openRejectModal() {
            document.getElementById('rejectModal').style.display = 'block';
        }
        
        function closeRejectModal() {
            document.getElementById('rejectModal').style.display = 'none';
        }
        
        window.onclick = function(event) {
            const modal = document.getElementById('rejectModal');
            if (event.target == modal) {
                closeRejectModal();
            }
        }
    </script>
</body>
</html>
