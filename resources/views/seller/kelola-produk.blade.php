<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kelola Produk - CampusMarket</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        /* --- RESET & BASIC --- */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6;
            color: #1f2937;
            min-height: 100vh;
            padding-bottom: 60px;
        }

        /* --- NAVBAR --- */
        .navbar {
            background: #01343B;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 3px solid #ACEB02;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .navbar-brand {
            font-size: 20px;
            font-weight: 700;
            color: white;
            letter-spacing: 0.5px;
        }
        .btn-logout {
            background: transparent;
            border: 2px solid rgba(255,255,255,0.8);
            color: white;
            padding: 8px 24px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.2s ease;
        }
        .btn-logout:hover {
            background: #ACEB02;
            color: #01343B;
            border-color: #ACEB02;
        }

        /* --- CONTAINER --- */
        .container {
            max-width: 1100px;
            margin: 40px auto;
            padding: 0 24px;
        }
        
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 32px;
        }

        .page-title h1 { font-size: 28px; font-weight: 800; color: #01343B; }
        .page-title p { color: #6b7280; font-size: 14px; margin-top: 4px; }

        .btn-back {
            color: #6b7280; text-decoration: none; font-weight: 500; font-size: 14px;
            display: inline-flex; align-items: center; gap: 6px; margin-bottom: 16px;
        }
        .btn-back:hover { color: #01343B; }

        .btn-primary {
            background: linear-gradient(135deg, #ACEB02 0%, #8BC900 100%);
            color: #01343B;
            font-weight: 700;
            border: none; border-radius: 10px; padding: 12px 28px; font-size: 15px;
            box-shadow: 0 4px 12px rgba(172, 235, 2, 0.3); transition: all 0.2s; cursor: pointer;
            display: inline-flex; align-items: center; gap: 8px;
        }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 6px 16px rgba(172, 235, 2, 0.4); }

        /* --- PRODUCT GRID --- */
        .produk-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 28px;
        }

        .produk-card {
            background: #fff; border-radius: 16px; overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.03); border: 1px solid rgba(0,0,0,0.05);
            transition: all 0.3s ease; display: flex; flex-direction: column; position: relative;
        }
        .produk-card:hover { transform: translateY(-5px); box-shadow: 0 12px 24px rgba(1, 52, 59, 0.08); border-color: #ACEB02; }

        .produk-thumb {
            width: 100%; height: 200px; object-fit: cover; background: #f9fafb; border-bottom: 1px solid #f3f4f6;
        }

        .produk-content { padding: 20px; display: flex; flex-direction: column; flex-grow: 1; }

        .produk-category { font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; color: #8BC900; font-weight: 700; margin-bottom: 6px; }
        .produk-title { font-size: 18px; font-weight: 700; color: #111827; margin-bottom: 8px; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        .produk-desc { font-size: 13px; color: #6b7280; line-height: 1.5; margin-bottom: 16px; height: 40px; overflow: hidden; }

        .produk-footer { margin-top: auto; border-top: 1px solid #f3f4f6; padding-top: 16px; display: flex; justify-content: space-between; align-items: center; }
        .produk-price { display: flex; flex-direction: column; gap: 4px; }
        .produk-price small { font-size: 11px; color: #9ca3af; line-height: 1; display: block; }
        .produk-price span { font-size: 16px; font-weight: 700; color: #01343B; line-height: 1.2; display: block; }
        .produk-stock { background: #f3f4f6; padding: 6px 10px; border-radius: 6px; font-size: 12px; font-weight: 600; color: #4b5563; }

        .produk-actions { padding: 0 20px 20px 20px; display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
        .btn-action { display: block; text-align: center; padding: 10px 0; border-radius: 8px; font-size: 13px; font-weight: 600; text-decoration: none; transition: background 0.2s; cursor: pointer; border: none; width: 100%; }
        .btn-edit { background: #f3f4f6; color: #01343B; }
        .btn-edit:hover { background: #e5e7eb; }
        .btn-delete { background: #fee2e2; color: #dc2626; }
        .btn-delete:hover { background: #fecaca; }

        /* --- MODAL --- */
        .modal-overlay { display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background: rgba(1, 52, 59, 0.6); backdrop-filter: blur(4px); }
        .modal-content { background: #fff; width: 90%; max-width: 550px; margin: 40px auto; border-radius: 20px; box-shadow: 0 20px 50px rgba(0,0,0,0.2); position: relative; max-height: 90vh; overflow-y: auto; }
        .modal-header { padding: 24px 32px; border-bottom: 1px solid #f3f4f6; display: flex; justify-content: space-between; align-items: center; background: #fafafa; }
        .modal-header h2 { font-size: 20px; font-weight: 700; color: #01343B; }
        .close-modal { background: none; border: none; font-size: 28px; color: #9ca3af; cursor: pointer; }
        .modal-body { padding: 32px; }

        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 600; font-size: 14px; color: #374151; }
        .form-control { width: 100%; padding: 12px 16px; border: 1px solid #d1d5db; border-radius: 10px; font-size: 14px; }
        
        .file-input-wrapper { background: #f9fafb; border: 2px dashed #d1d5db; border-radius: 10px; padding: 20px; text-align: center; }
        .file-input-wrapper.edit-mode { background: #f0fdf4; border-color: #16a34a; color: #166534; }
        
        .btn-submit-modal { width: 100%; background: #01343B; color: #fff; padding: 14px; border-radius: 10px; border: none; font-weight: 700; font-size: 16px; cursor: pointer; }
        .alert { padding: 15px; margin-bottom: 20px; border-radius: 10px; font-size: 14px; }
        .alert-success { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
        .alert-error { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }

        /* CSS KHUSUS GALLERY EDIT */
        #existing-images-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            margin-top: 10px;
        }
        .existing-img-card {
            position: relative;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #e5e7eb;
            height: 80px;
        }
        .existing-img-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .btn-remove-img {
            position: absolute;
            top: 4px;
            right: 4px;
            background: rgba(220, 38, 38, 0.9);
            color: white;
            border: none;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            font-size: 16px;
            line-height: 1;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.2s;
        }
        .btn-remove-img:hover {
            transform: scale(1.1);
            background: rgba(220, 38, 38, 1);
        }
        .img-label-primary {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            background: rgba(0,0,0,0.6);
            color: white;
            font-size: 10px;
            text-align: center;
            padding: 2px 0;
        }
    </style>
</head>
<body>

    @include('seller.navbar')

    <div class="container">
        @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
        @if($errors->any()) <div class="alert alert-error"> <ul> @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach </ul> </div> @endif

        <a href="{{ route('seller.dashboard') }}" class="btn-back">
            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            Kembali ke Dashboard
        </a>

        <div class="page-header">
            <div class="page-title">
                <h1>Daftar Produk</h1>
                <p>Kelola inventaris barang dagangan Anda di sini.</p>
            </div>
            <button id="btnTambahProduk" class="btn-primary"><span>+</span> Tambah Produk</button>
        </div>

        @if(count($products) > 0)
            <div class="produk-grid">
                @foreach($products as $product)
                    @php
                        $primaryImage = isset($product->images) ? collect($product->images)->where('is_primary', true)->first() : null;
                        $thumbUrl = $primaryImage ? asset('storage/' . $primaryImage->image_path) : 'https://via.placeholder.com/400x300?text=No+Image';
                    @endphp

                    <div class="produk-card">
                        <img src="{{ $thumbUrl }}" alt="{{ $product->name }}" class="produk-thumb">
                        <div class="produk-content">
                            <div class="produk-category">{{ $product->category }}</div>
                            <div class="produk-title">{{ $product->name }}</div>
                            <div class="produk-desc">{{ Str::limit($product->description, 70) }}</div>
                            <div class="produk-footer">
                                <div class="produk-price">
                                    <small>Harga</small><span>Rp {{ number_format($product->price,0,',','.') }}</span>
                                </div>
                                <div class="produk-stock">Stok: {{ $product->stock }}</div>
                            </div>
                        </div>
                        <div class="produk-actions">
                            <button type="button" 
                                class="btn-action btn-edit btn-open-edit"
                                data-id="{{ $product->id }}"
                                data-name="{{ $product->name }}"
                                data-category="{{ $product->category }}"
                                data-price="{{ (int) $product->price }}" 
                                data-stock="{{ $product->stock }}"
                                data-description="{{ $product->description }}"
                                data-action-url="{{ route('seller.produk.update', $product->id) }}"
                                data-images="{{ json_encode($product->images) }}" 
                            >Edit</button>

                            <form method="POST" action="{{ route('seller.produk.destroy', $product->id) }}" onsubmit="return confirm('Yakin hapus produk ini?');" style="display:contents;">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-action btn-delete">Hapus</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div style="text-align:center; padding:60px 0; color:#9ca3af;"><h3>Belum ada produk</h3></div>
        @endif
    </div>

    <div id="modalTambahProduk" class="modal-overlay">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Tambah Produk</h2>
                <button class="close-modal close-modal-tambah">&times;</button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('seller.kelola-produk.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group"><label>Nama Produk <span style="color:red">*</span></label><input type="text" class="form-control" name="name" required></div>
                    <div class="form-group"><label>Kategori <span style="color:red">*</span></label><input type="text" class="form-control" name="category" required></div>
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">
                        <div class="form-group"><label>Harga <span style="color:red">*</span></label><input type="number" class="form-control" name="price" required></div>
                        <div class="form-group"><label>Stok <span style="color:red">*</span></label><input type="number" class="form-control" name="stock" required></div>
                    </div>
                    <div class="form-group"><label>Deskripsi <span style="color:red">*</span></label><textarea class="form-control" name="description" rows="3" required></textarea></div>
                    <div class="form-group">
                        <label>Gambar Utama (Wajib) <span style="color:red">*</span></label>
                        <div class="file-input-wrapper"><input type="file" name="primary_image" accept="image/*" required></div>
                    </div>
                    <div class="form-group">
                        <label>Galeri Tambahan (Opsional)</label>
                        <div class="file-input-wrapper"><input type="file" name="images[]" accept="image/*" multiple></div>
                    </div>
                    <button type="submit" class="btn-submit-modal">Simpan Produk</button>
                </form>
            </div>
        </div>
    </div>

    <div id="modalEditProduk" class="modal-overlay">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Edit Produk</h2>
                <button class="close-modal close-modal-edit">&times;</button>
            </div>
            <div class="modal-body">
                <form id="formEdit" method="POST" action="" enctype="multipart/form-data">
                    @csrf @method('PUT') 
                    
                    <div class="form-group"><label>Nama Produk <span style="color:red">*</span></label><input type="text" class="form-control" name="name" id="edit_name" required></div>
                    <div class="form-group"><label>Kategori <span style="color:red">*</span></label><input type="text" class="form-control" name="category" id="edit_category" required></div>
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">
                        <div class="form-group"><label>Harga <span style="color:red">*</span></label><input type="number" class="form-control" name="price" id="edit_price" required></div>
                        <div class="form-group"><label>Stok <span style="color:red">*</span></label><input type="number" class="form-control" name="stock" id="edit_stock" required></div>
                    </div>
                    <div class="form-group"><label>Deskripsi <span style="color:red">*</span></label><textarea class="form-control" name="description" id="edit_description" rows="3" required></textarea></div>
                    
                    <div class="form-group">
                        <label>Gambar Saat Ini</label>
                        <div id="existing-images-container">
                            </div>
                    </div>

                    <div class="form-group">
                        <label>Ganti Gambar Utama (Opsional)</label>
                        <div class="file-input-wrapper edit-mode">
                            <input type="file" name="primary_image" accept="image/*">
                        </div>
                        <div style="background:#fefce8; border:1px solid #fde047; padding:12px; border-radius:8px; margin-top:12px; text-align:center;">
                            <p style="color:#854d0e; font-weight:700; font-size:14px; margin:0;">⚠ Biarkan kosong jika tidak ingin mengubah gambar utama.</p>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Tambah ke Galeri (Opsional)</label>
                        <div class="file-input-wrapper">
                            <input type="file" name="images[]" accept="image/*" multiple>
                        </div>
                    </div>

                    <button type="submit" class="btn-submit-modal">Update Produk</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        const modalTambah = document.getElementById('modalTambahProduk');
        const btnTambah = document.getElementById('btnTambahProduk');
        const closeTambah = document.querySelector('.close-modal-tambah');

        btnTambah.onclick = () => { modalTambah.style.display = 'block'; }
        closeTambah.onclick = () => { modalTambah.style.display = 'none'; }

        // --- EDIT MODAL LOGIC ---
        const modalEdit = document.getElementById('modalEditProduk');
        const closeEdit = document.querySelector('.close-modal-edit');
        const btnsEdit = document.querySelectorAll('.btn-open-edit');
        const imagesContainer = document.getElementById('existing-images-container');

        btnsEdit.forEach(btn => {
            btn.onclick = function() {
                const name = this.getAttribute('data-name');
                const category = this.getAttribute('data-category');
                const price = this.getAttribute('data-price');
                const stock = this.getAttribute('data-stock');
                const desc = this.getAttribute('data-description');
                const actionUrl = this.getAttribute('data-action-url');
                
                // Ambil data gambar (JSON)
                const imagesData = JSON.parse(this.getAttribute('data-images'));

                // Isi Form
                document.getElementById('edit_name').value = name;
                document.getElementById('edit_category').value = category;
                document.getElementById('edit_price').value = price;
                document.getElementById('edit_stock').value = stock;
                document.getElementById('edit_description').value = desc;
                document.getElementById('formEdit').action = actionUrl;

                // Render Daftar Gambar
                imagesContainer.innerHTML = ''; // Bersihkan dulu
                
                if(imagesData && imagesData.length > 0) {
                    imagesData.forEach(img => {
                        const div = document.createElement('div');
                        div.className = 'existing-img-card';
                        
                        // Label jika Primary
                        const label = img.is_primary ? '<div class="img-label-primary">Utama</div>' : '';
                        
                        // Path Gambar (sesuaikan 'storage/' jika perlu)
                        const imgSrc = `/storage/${img.image_path}`;

                        div.innerHTML = `
                            <img src="${imgSrc}" alt="Produk">
                            ${label}
                            <button type="button" class="btn-remove-img" onclick="hapusGambar(${img.id}, this)">
                                &times;
                            </button>
                        `;
                        imagesContainer.appendChild(div);
                    });
                } else {
                    imagesContainer.innerHTML = '<small style="color:#888;">Tidak ada gambar</small>';
                }

                modalEdit.style.display = 'block';
            }
        });

        closeEdit.onclick = () => { modalEdit.style.display = 'none'; }
        window.onclick = function(event) {
            if (event.target === modalTambah) modalTambah.style.display = 'none';
            if (event.target === modalEdit) modalEdit.style.display = 'none';
        }

        // --- FUNGSI HAPUS GAMBAR (AJAX) ---
        function hapusGambar(imageId, btnElement) {
            if(!confirm("Yakin ingin menghapus gambar ini?")) return;

            const card = btnElement.closest('.existing-img-card');
            
            // Panggil API Delete
            fetch(`/seller/image/${imageId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if(data.status === 'success') {
                    // Hapus elemen HTML
                    card.remove();
                } else {
                    alert('Gagal menghapus: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan sistem.');
            });
        }
    </script>
</body>
</html>