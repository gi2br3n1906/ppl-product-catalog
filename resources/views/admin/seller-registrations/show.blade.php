<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Registrasi - Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f7fa;
            min-height: 100vh;
        }
        
        .navbar {
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .navbar-brand {
            font-size: 24px;
            font-weight: bold;
            background: linear-gradient(135deg, #01343B 0%, #023840 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .container {
            max-width: 1000px;
            margin: 30px auto;
            padding: 0 20px;
        }
        
        .back-button {
            display: inline-block;
            margin-bottom: 20px;
            color: #01343B;
            text-decoration: none;
            font-weight: 600;
        }
        
        .back-button:hover {
            text-decoration: underline;
        }
        
        .detail-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        .status-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #ACEB02;
        }
        
        .status-header h1 {
            color: #01343B;
        }
        
        .badge {
            display: inline-block;
            padding: 8px 20px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
        }
        
        .badge-pending {
            background: #fff3cd;
            color: #856404;
        }
        
        .badge-approved {
            background: #d4edda;
            color: #155724;
        }
        
        .badge-rejected {
            background: #f8d7da;
            color: #721c24;
        }
        
        .section-title {
            color: #01343B;
            font-size: 18px;
            font-weight: bold;
            margin: 25px 0 15px 0;
            padding-bottom: 10px;
            border-bottom: 2px solid #ACEB02;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .info-item {
            margin-bottom: 15px;
        }
        
        .info-label {
            color: #666;
            font-size: 13px;
            margin-bottom: 5px;
        }
        
        .info-value {
            color: #333;
            font-size: 15px;
            font-weight: 600;
        }
        
        .document-preview {
            margin: 20px 0;
        }
        
        .document-preview img {
            max-width: 100%;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        .document-link {
            display: inline-block;
            padding: 10px 20px;
            background: #01343B;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            margin-top: 10px;
        }
        
        .document-link:hover {
            background: #023840;
        }
        
        .action-buttons {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }
        
        .btn {
            padding: 14px 30px;
            border-radius: 10px;
            border: none;
            cursor: pointer;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.2s;
            flex: 1;
        }
        
        .btn-approve {
            background: #28a745;
            color: white;
        }
        
        .btn-approve:hover {
            background: #218838;
            transform: translateY(-2px);
        }
        
        .btn-reject {
            background: #dc3545;
            color: white;
        }
        
        .btn-reject:hover {
            background: #c82333;
            transform: translateY(-2px);
        }
        
        .btn:disabled {
            background: #ccc;
            cursor: not-allowed;
        }
        
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
        }
        
        .modal.active {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .modal-content {
            background: white;
            border-radius: 15px;
            padding: 30px;
            max-width: 500px;
            width: 90%;
        }
        
        .modal-header {
            margin-bottom: 20px;
        }
        
        .modal-header h2 {
            color: #01343B;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }
        
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #e1e1e1;
            border-radius: 8px;
            min-height: 120px;
            font-family: inherit;
        }
        
        .modal-buttons {
            display: flex;
            gap: 10px;
        }
        
        .btn-modal {
            padding: 10px 20px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-weight: 600;
            flex: 1;
        }
        
        .btn-modal-cancel {
            background: #6c757d;
            color: white;
        }
        
        .btn-modal-submit {
            background: #dc3545;
            color: white;
        }
        
        .alert {
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        
        .alert-success {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
        }
        
        .alert-error {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="navbar-brand">Admin - Product Catalog</div>
    </nav>

    <div class="container">
        <a href="{{ route('admin.seller-registrations.index') }}" class="back-button">← Kembali ke Daftar</a>

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
            <div class="status-header">
                <h1>Detail Registrasi Seller</h1>
                @if ($registration->status === 'pending')
                    <span class="badge badge-pending">⏳ Pending</span>
                @elseif ($registration->status === 'approved')
                    <span class="badge badge-approved">✅ Approved</span>
                @else
                    <span class="badge badge-rejected">❌ Rejected</span>
                @endif
            </div>

            <!-- Data Toko -->
            <div class="section-title">📦 Data Toko</div>
            <div class="info-item">
                <div class="info-label">Nama Toko</div>
                <div class="info-value">{{ $registration->nama_toko }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Deskripsi Singkat</div>
                <div class="info-value">{{ $registration->deskripsi_singkat }}</div>
            </div>

            <!-- Data PIC -->
            <div class="section-title">👤 Data PIC</div>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Nama PIC</div>
                    <div class="info-value">{{ $registration->nama_pic }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">No HP</div>
                    <div class="info-value">{{ $registration->no_hp_pic }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Email</div>
                    <div class="info-value">{{ $registration->email_pic }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">No KTP</div>
                    <div class="info-value">{{ $registration->no_ktp_pic }}</div>
                </div>
            </div>

            <!-- Alamat PIC -->
            <div class="section-title">📍 Alamat PIC</div>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Jalan</div>
                    <div class="info-value">{{ $registration->jalan }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">RT/RW</div>
                    <div class="info-value">{{ $registration->rt }}/{{ $registration->rw }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Kelurahan</div>
                    <div class="info-value">{{ $registration->kelurahan }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Kab/Kota</div>
                    <div class="info-value">{{ $registration->kab_kota }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Provinsi</div>
                    <div class="info-value">{{ $registration->provinsi }}</div>
                </div>
            </div>

            <!-- Dokumen -->
            <div class="section-title">📄 Dokumen Identitas</div>
            
            <div class="document-preview">
                <div class="info-label">Foto PIC</div>
                @if ($registration->foto_pic)
                    <img src="{{ Storage::url($registration->foto_pic) }}" alt="Foto PIC" style="max-width: 300px;">
                    <br>
                    <a href="{{ Storage::url($registration->foto_pic) }}" target="_blank" class="document-link">
                        📷 Lihat Foto Lengkap
                    </a>
                @endif
            </div>

            <div class="document-preview">
                <div class="info-label">File KTP</div>
                @if ($registration->file_ktp)
                    @if (str_ends_with($registration->file_ktp, '.pdf'))
                        <a href="{{ Storage::url($registration->file_ktp) }}" target="_blank" class="document-link">
                            📄 Buka File KTP (PDF)
                        </a>
                    @else
                        <img src="{{ Storage::url($registration->file_ktp) }}" alt="KTP" style="max-width: 500px;">
                        <br>
                        <a href="{{ Storage::url($registration->file_ktp) }}" target="_blank" class="document-link">
                            📄 Lihat KTP Lengkap
                        </a>
                    @endif
                @endif
            </div>

            @if ($registration->status === 'rejected' && $registration->rejection_reason)
                <div class="section-title">❌ Alasan Penolakan</div>
                <div class="info-item">
                    <div class="info-value" style="color: #dc3545;">{{ $registration->rejection_reason }}</div>
                </div>
            @endif

            @if ($registration->verified_at)
                <div class="section-title">ℹ️ Informasi Verifikasi</div>
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Diverifikasi pada</div>
                        <div class="info-value">{{ $registration->verified_at->format('d/m/Y H:i') }}</div>
                    </div>
                    @if ($registration->verifiedBy)
                        <div class="info-item">
                            <div class="info-label">Diverifikasi oleh</div>
                            <div class="info-value">{{ $registration->verifiedBy->name }}</div>
                        </div>
                    @endif
                </div>
            @endif

            <!-- Action Buttons -->
            @if ($registration->status === 'pending')
                <div class="action-buttons">
                    <form action="{{ route('admin.seller-registrations.approve', $registration->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-approve" onclick="return confirm('Apakah Anda yakin ingin menyetujui registrasi ini?')">
                            ✅ Setujui
                        </button>
                    </form>
                    
                    <button type="button" class="btn btn-reject" onclick="openRejectModal()">
                        ❌ Tolak
                    </button>
                </div>
            @endif
        </div>
    </div>

    <!-- Modal Reject -->
    <div id="rejectModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Tolak Registrasi</h2>
            </div>
            <form action="{{ route('admin.seller-registrations.reject', $registration->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="rejection_reason">Alasan Penolakan <span style="color: red;">*</span></label>
                    <textarea 
                        id="rejection_reason" 
                        name="rejection_reason" 
                        placeholder="Jelaskan alasan penolakan..."
                        required
                    ></textarea>
                </div>
                <div class="modal-buttons">
                    <button type="button" class="btn-modal btn-modal-cancel" onclick="closeRejectModal()">Batal</button>
                    <button type="submit" class="btn-modal btn-modal-submit">Tolak Registrasi</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openRejectModal() {
            document.getElementById('rejectModal').classList.add('active');
        }

        function closeRejectModal() {
            document.getElementById('rejectModal').classList.remove('active');
        }

        // Close modal when clicking outside
        document.getElementById('rejectModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeRejectModal();
            }
        });
    </script>
</body>
</html>
