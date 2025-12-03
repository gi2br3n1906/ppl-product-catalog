<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Seller - Product Catalog</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #ACEB02 0%, #8BC900 100%);
            min-height: 100vh;
            padding: 40px 20px;
        }
        
        .register-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            max-width: 700px;
            width: 100%;
            margin: 0 auto;
            padding: 40px;
        }
        
        .register-header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px solid #01343B;
        }
        
        .register-header h1 {
            color: #01343B;
            font-size: 28px;
            margin-bottom: 10px;
        }
        
        .section-title {
            color: #01343B;
            font-size: 20px;
            font-weight: bold;
            margin: 30px 0 20px 0;
            padding: 10px 0;
            position: relative;
        }
        
        .section-title::before {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 100px;
            height: 2px;
            background: #01343B;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }
        
        .form-group label {
            display: block;
            color: #333;
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 14px;
        }
        
        .required {
            color: #e74c3c;
        }
        

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e1e1e1;
            border-radius: 10px;
            font-size: 14px;
            transition: all 0.3s ease;
            background: #fff;
            appearance: none;
        }
        

        .form-group textarea {
            min-height: 100px;
            resize: vertical;
        }

        .form-group select:focus,
        .form-group select:hover {
            outline: none;
            border-color: #01343B;
            box-shadow: 0 0 0 3px rgba(1, 52, 59, 0.1);
        }

        .form-group select option {
            background: #fff;
            color: #333;
        }
        
        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #01343B;
            box-shadow: 0 0 0 3px rgba(1, 52, 59, 0.1);
        }
        
        .file-input-wrapper {
            position: relative;
        }
        
        .file-input-label {
            display: inline-block;
            padding: 10px 20px;
            background: #f8f9fa;
            border: 2px dashed #01343B;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
            width: 100%;
        }
        
        .file-input-label:hover {
            background: #e9ecef;
        }
        
        .file-input {
            display: none;
        }
        
        .file-name {
            margin-top: 8px;
            font-size: 12px;
            color: #666;
            font-style: italic;
        }
        
        .error-message {
            color: #e74c3c;
            font-size: 12px;
            margin-top: 5px;
        }
        
        .btn-submit {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #01343B 0%, #023840 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            margin-top: 30px;
        }
        
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(1, 52, 59, 0.3);
        }
        
        .btn-submit:active {
            transform: translateY(0);
        }
        
        .btn-cancel {
            width: 100%;
            padding: 14px;
            background: #6c757d;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 10px;
            text-decoration: none;
            display: block;
            text-align: center;
        }
        
        .btn-cancel:hover {
            background: #5a6268;
        }
        
        .alert {
            padding: 12px 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 14px;
        }
        
        .alert-error {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
        }
        
        .password-requirements {
            font-size: 12px;
            color: #666;
            margin-top: 5px;
            line-height: 1.5;
        }
        
        .info-box {
            background: #e7f3ff;
            border-left: 4px solid #01343B;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        
        .info-box strong {
            color: #01343B;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-header">
            <h1>Formulir Registrasi Data Penjual (Toko)</h1>
        </div>

        <div class="info-box">
            <strong>Perhatian:</strong> Semua data akan diverifikasi oleh admin. Anda akan menerima email notifikasi setelah proses verifikasi selesai.
        </div>

        @if ($errors->any())
            <div class="alert alert-error">
                <ul style="list-style: none; padding-left: 0; margin: 0;">
                    @foreach ($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('seller.register') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <!-- Data Toko -->
            <div class="section-title">Data Toko</div>
            
            <div class="form-group">
                <label for="nama_toko">Nama Toko <span class="required">*</span></label>
                <input 
                    type="text" 
                    id="nama_toko" 
                    name="nama_toko" 
                    value="{{ old('nama_toko') }}" 
                    placeholder="Masukkan nama toko"
                    required
                >
                @error('nama_toko')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="deskripsi_singkat">Deskripsi Singkat <span class="required">*</span></label>
                <textarea 
                    id="deskripsi_singkat" 
                    name="deskripsi_singkat" 
                    placeholder="Deskripsikan toko Anda"
                    required
                >{{ old('deskripsi_singkat') }}</textarea>
                @error('deskripsi_singkat')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- Data PIC -->
            <div class="section-title">Data PIC</div>
            
            <div class="form-group">
                <label for="nama_pic">Nama PIC <span class="required">*</span></label>
                <input 
                    type="text" 
                    id="nama_pic" 
                    name="nama_pic" 
                    value="{{ old('nama_pic') }}" 
                    placeholder="Nama Person In Charge"
                    required
                >
                @error('nama_pic')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="no_hp_pic">No HP PIC <span class="required">*</span></label>
                    <input 
                        type="text" 
                        id="no_hp_pic" 
                        name="no_hp_pic" 
                        value="{{ old('no_hp_pic') }}" 
                        placeholder="08xxxxxxxxxx"
                        required
                    >
                    @error('no_hp_pic')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email_pic">Email PIC <span class="required">*</span></label>
                    <input 
                        type="email" 
                        id="email_pic" 
                        name="email_pic" 
                        value="{{ old('email_pic') }}" 
                        placeholder="email@example.com"
                        required
                    >
                    @error('email_pic')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Alamat PIC -->
            <div class="section-title">Alamat PIC</div>
            
            <div class="form-group">
                <label for="jalan">Jalan <span class="required">*</span></label>
                <input 
                    type="text" 
                    id="jalan" 
                    name="jalan" 
                    value="{{ old('jalan') }}" 
                    placeholder="Nama jalan dan nomor rumah"
                    required
                >
                @error('jalan')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="rt">RT <span class="required">*</span></label>
                    <input 
                        type="text" 
                        id="rt" 
                        name="rt" 
                        value="{{ old('rt') }}" 
                        placeholder="001"
                        required
                    >
                    @error('rt')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="rw">RW <span class="required">*</span></label>
                    <input 
                        type="text" 
                        id="rw" 
                        name="rw" 
                        value="{{ old('rw') }}" 
                        placeholder="001"
                        required
                    >
                    @error('rw')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
<<<<<<< HEAD
=======
                    <label for="kab_kota">Kabupaten/Kota <span class="required">*</span></label>
                    <input 
                        type="text" 
                        id="kab_kota" 
                        name="kab_kota" 
                        value="{{ old('kab_kota') }}" 
                        placeholder="Kabupaten/Kota"
                        required
                    >
                    @error('kab_kota')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
>>>>>>> origin
                    <label for="provinsi">Provinsi <span class="required">*</span></label>
                    <select id="provinsi" name="provinsi" required>
                        <option value="">Pilih Provinsi</option>
                    </select>
                    @error('provinsi')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="kabupaten">Kabupaten/Kota <span class="required">*</span></label>
                    <select id="kabupaten" name="kab_kota" required>
                        <option value="">Pilih Kabupaten/Kota</option>
                    </select>
                    @error('kab_kota')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="kecamatan">Kecamatan <span class="required">*</span></label>
                    <select id="kecamatan" name="kecamatan" required>
                        <option value="">Pilih Kecamatan</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="kelurahan">Kelurahan <span class="required">*</span></label>
                    <select id="kelurahan" name="kelurahan" required>
                        <option value="">Pilih Kelurahan</option>
                    </select>
                    @error('kelurahan')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Dropdown wilayah diganti, lihat atas -->

            <!-- Dokumen Identitas PIC -->
            <div class="section-title">Dokumen Identitas PIC</div>
            
            <div class="form-group">
                <label for="no_ktp_pic">No. KTP PIC <span class="required">*</span></label>
                <input 
                    type="text" 
                    id="no_ktp_pic" 
                    name="no_ktp_pic" 
                    value="{{ old('no_ktp_pic') }}" 
                    placeholder="16 digit nomor KTP"
                    maxlength="16"
                    required
                >
                @error('no_ktp_pic')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="foto_pic">Pas Foto PIC (jpg/png, ≤2MB) <span class="required">*</span></label>
                <div class="file-input-wrapper">
                    <label for="foto_pic" class="file-input-label">
                        <span id="foto_pic_label">Unggah Pas Foto</span>
                    </label>
                    <input 
                        type="file" 
                        id="foto_pic" 
                        name="foto_pic" 
                        class="file-input" 
                        accept="image/jpeg,image/png"
                        required
                        onchange="updateFileName(this, 'foto_pic_label', 'foto_pic_name')"
                    >
                    <div id="foto_pic_name" class="file-name"></div>
                </div>
                @error('foto_pic')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="file_ktp">KTP (jpg/png/pdf, ≤5MB) <span class="required">*</span></label>
                <div class="file-input-wrapper">
                    <label for="file_ktp" class="file-input-label">
                        <span id="file_ktp_label">Unggah KTP</span>
                    </label>
                    <input 
                        type="file" 
                        id="file_ktp" 
                        name="file_ktp" 
                        class="file-input"
                        accept="image/jpeg,image/png,application/pdf"
                        required
                        onchange="updateFileName(this, 'file_ktp_label', 'file_ktp_name')"
                    >
                    <div id="file_ktp_name" class="file-name"></div>
                </div>
                @error('file_ktp')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password -->
            <div class="section-title">Keamanan Akun</div>
            
            <div class="form-group">
                <label for="password">Password <span class="required">*</span></label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    placeholder="Minimal 8 karakter"
                    required
                >
                <div class="password-requirements">
                    Password harus mengandung: huruf besar, huruf kecil, angka, dan simbol
                </div>
                @error('password')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Konfirmasi Password <span class="required">*</span></label>
                <input 
                    type="password" 
                    id="password_confirmation" 
                    name="password_confirmation" 
                    placeholder="Ulangi password"
                    required
                >
            </div>

            <button type="submit" class="btn-submit">Registrasi Penjual</button>
            <a href="{{ route('catalog') }}" class="btn-cancel">Batal</a>
        </form>
    </div>

    <script>
        function updateFileName(input, labelId, nameId) {
            const label = document.getElementById(labelId);
            const nameDiv = document.getElementById(nameId);
            if (input.files && input.files[0]) {
                const fileName = input.files[0].name;
                const fileSize = (input.files[0].size / 1024 / 1024).toFixed(2); // MB
                label.textContent = '✅ File dipilih';
                nameDiv.textContent = `${fileName} (${fileSize} MB)`;
            } else {
                label.textContent = labelId.includes('foto') ? '📷 Pilih File Foto' : '📄 Pilih File KTP';
                nameDiv.textContent = '';
            }
        }

        // Dropdown wilayah dinamis
        document.addEventListener('DOMContentLoaded', function() {
            const provinsiSelect = document.getElementById('provinsi');
            const kabupatenSelect = document.getElementById('kabupaten');
            const kecamatanSelect = document.getElementById('kecamatan');
            const kelurahanSelect = document.getElementById('kelurahan');

            // Provinsi
            fetch('/api/wilayah/provinsi')
                .then(res => res.json())
                .then(data => {
                    data.forEach(item => {
                        const opt = document.createElement('option');
                        opt.value = item.id;
                        opt.textContent = item.name;
                        provinsiSelect.appendChild(opt);
                    });
                });

            provinsiSelect.addEventListener('change', function() {
                kabupatenSelect.innerHTML = '<option value="">Pilih Kabupaten/Kota</option>';
                kecamatanSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
                kelurahanSelect.innerHTML = '<option value="">Pilih Kelurahan</option>';
                if (!this.value) return;
                fetch(`/api/wilayah/kabupaten?provinsi_id=${this.value}`)
                    .then(res => res.json())
                    .then(data => {
                        data.forEach(item => {
                            const opt = document.createElement('option');
                            opt.value = item.id;
                            opt.textContent = item.name;
                            kabupatenSelect.appendChild(opt);
                        });
                    });
            });

            kabupatenSelect.addEventListener('change', function() {
                kecamatanSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
                kelurahanSelect.innerHTML = '<option value="">Pilih Kelurahan</option>';
                if (!this.value) return;
                fetch(`/api/wilayah/kecamatan?kabupaten_id=${this.value}`)
                    .then(res => res.json())
                    .then(data => {
                        data.forEach(item => {
                            const opt = document.createElement('option');
                            opt.value = item.id;
                            opt.textContent = item.name;
                            kecamatanSelect.appendChild(opt);
                        });
                    });
            });

            kecamatanSelect.addEventListener('change', function() {
                kelurahanSelect.innerHTML = '<option value="">Pilih Kelurahan</option>';
                if (!this.value) return;
                fetch(`/api/wilayah/kelurahan?kecamatan_id=${this.value}`)
                    .then(res => res.json())
                    .then(data => {
                        data.forEach(item => {
                            const opt = document.createElement('option');
                            opt.value = item.name;
                            opt.textContent = item.name;
                            kelurahanSelect.appendChild(opt);
                        });
                    });
            });
        });
    </script>
</body>
</html>
