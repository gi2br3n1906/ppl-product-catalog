# 🔐 Sistem Autentikasi - Product Catalog

## 📋 Daftar Isi
- [Overview](#overview)
- [Fitur](#fitur)
- [File yang Dibuat](#file-yang-dibuat)
- [Penjelasan Detail](#penjelasan-detail)
- [Cara Menggunakan](#cara-menggunakan)
- [Testing](#testing)
- [Security Features](#security-features)

---

## 🎯 Overview

Sistem autentikasi lengkap untuk aplikasi Product Catalog yang mencakup fitur **Registrasi**, **Login**, dan **Logout** dengan tampilan UI modern dan validasi keamanan yang ketat.

---

## ✨ Fitur

### 1. **Registrasi User**
- Form registrasi yang user-friendly
- Validasi input yang ketat:
  - Nama wajib diisi
  - Email harus valid dan unik
  - Password minimal 8 karakter dengan kombinasi:
    - Huruf besar (A-Z)
    - Huruf kecil (a-z)
    - Angka (0-9)
    - Simbol (!@#$%^&*, dll)
- Auto-login setelah registrasi berhasil
- Pesan error dalam Bahasa Indonesia

### 2. **Login User**
- Form login sederhana dan aman
- Fitur "Remember Me" untuk sesi yang lebih lama
- Validasi credentials
- Session management yang aman
- Redirect ke dashboard setelah login berhasil

### 3. **Logout**
- Logout aman dengan session invalidation
- Regenerasi token CSRF
- Redirect ke halaman login dengan pesan sukses

### 4. **Dashboard**
- Halaman dashboard setelah login
- Menampilkan informasi user yang sedang login
- Statistik dasar aplikasi
- UI modern dengan gradient design

---

## 📁 File yang Dibuat

### 1. **Controller**
```
app/Http/Controllers/AuthController.php
```

**Fungsi:**
- `showRegisterForm()` - Menampilkan halaman registrasi
- `register()` - Memproses registrasi user baru
- `showLoginForm()` - Menampilkan halaman login
- `login()` - Memproses login user
- `logout()` - Memproses logout user

**Fitur Keamanan:**
- Password hashing menggunakan `Hash::make()`
- Validasi input dengan Laravel Validator
- CSRF protection otomatis
- Session regeneration setelah login

---

### 2. **Views (Blade Templates)**

#### a. `resources/views/auth/register.blade.php`
**Deskripsi:** Form registrasi dengan desain modern

**Komponen:**
- Input field: Nama, Email, Password, Konfirmasi Password
- Validasi real-time dengan error messages
- Password requirements hint
- Link ke halaman login
- Responsive design

**Styling:**
- Gradient background (purple theme)
- Card-based layout
- Modern rounded inputs
- Hover effects pada button
- Error messages dengan warna merah

---

#### b. `resources/views/auth/login.blade.php`
**Deskripsi:** Form login dengan UI yang clean

**Komponen:**
- Input field: Email, Password
- Checkbox "Remember Me"
- Link ke halaman registrasi
- Success/Error alert messages
- Auto-focus pada email input

**Styling:**
- Konsisten dengan halaman register
- Smooth transitions
- Shadow effects
- Gradient button

---

#### c. `resources/views/dashboard.blade.php`
**Deskripsi:** Dashboard untuk user yang sudah login

**Komponen:**
- Navbar dengan user info dan logout button
- Welcome message dengan nama user
- Statistics cards:
  - Total Produk (placeholder: 0)
  - Kategori (placeholder: 0)
  - User Terdaftar (dinamis dari database)
- Grid layout yang responsive

**Styling:**
- Professional navbar
- Stats cards dengan gradient warna berbeda
- Clean and modern design
- Responsive grid layout

---

### 3. **Routes**
```
routes/web.php
```

**Route Groups:**

#### Guest Routes (untuk user yang belum login):
```php
// Registrasi
GET  /register  -> Tampilkan form registrasi
POST /register  -> Proses registrasi

// Login
GET  /login     -> Tampilkan form login
POST /login     -> Proses login
```

#### Protected Routes (untuk user yang sudah login):
```php
GET  /dashboard -> Tampilkan dashboard
POST /logout    -> Proses logout
```

**Middleware:**
- `guest` - Hanya bisa diakses jika belum login
- `auth` - Hanya bisa diakses jika sudah login

---

## 🔍 Penjelasan Detail

### Alur Registrasi

1. **User mengakses** `/register`
2. **Sistem menampilkan** form registrasi
3. **User mengisi** data:
   - Nama lengkap
   - Email
   - Password (min 8 karakter dengan kombinasi)
   - Konfirmasi password
4. **Sistem memvalidasi** input:
   - Cek apakah semua field diisi
   - Cek format email
   - Cek email belum terdaftar di database
   - Cek kekuatan password
   - Cek konfirmasi password cocok
5. **Jika validasi gagal:**
   - Tampilkan error message dalam Bahasa Indonesia
   - Pertahankan data yang sudah diisi (kecuali password)
6. **Jika validasi berhasil:**
   - Hash password menggunakan bcrypt
   - Simpan user baru ke database
   - Auto-login user tersebut
   - Redirect ke dashboard dengan pesan sukses

### Alur Login

1. **User mengakses** `/login`
2. **Sistem menampilkan** form login
3. **User mengisi** email dan password
4. **User bisa centang** "Remember Me" (opsional)
5. **Sistem memvalidasi** credentials:
   - Cek email dan password di database
   - Bandingkan password dengan hash di database
6. **Jika login gagal:**
   - Tampilkan error "Email atau password salah"
   - Pertahankan email yang diisi
7. **Jika login berhasil:**
   - Buat session baru
   - Regenerate session ID (security)
   - Redirect ke dashboard

### Alur Logout

1. **User klik** tombol Logout di dashboard
2. **Sistem melakukan:**
   - Hapus session user dari Auth
   - Invalidate session ID
   - Regenerate CSRF token
3. **Redirect** ke halaman login dengan pesan "Berhasil logout"

---

## 🚀 Cara Menggunakan

### 1. Setup Database

Pastikan file `.env` sudah dikonfigurasi dengan benar:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=product_catalog
DB_USERNAME=root
DB_PASSWORD=
```

### 2. Jalankan Migration

```bash
php artisan migrate
```

Migration akan membuat tabel `users` dengan kolom:
- id
- name
- email (unique)
- password (hashed)
- remember_token
- timestamps

### 3. Jalankan Aplikasi

```bash
php artisan serve
```

### 4. Akses Aplikasi

- **Registrasi:** http://localhost:8000/register
- **Login:** http://localhost:8000/login
- **Dashboard:** http://localhost:8000/dashboard (setelah login)

---

## 🧪 Testing

### Test Manual Registrasi

1. Buka http://localhost:8000/register
2. Coba isi dengan data tidak valid:
   - Email tanpa @
   - Password kurang dari 8 karakter
   - Password tanpa huruf besar/kecil/angka/simbol
   - Konfirmasi password tidak cocok
3. Lihat error messages muncul
4. Isi dengan data valid:
   ```
   Nama: John Doe
   Email: john@example.com
   Password: Password123!
   Konfirmasi: Password123!
   ```
5. Submit dan lihat redirect ke dashboard

### Test Manual Login

1. Buka http://localhost:8000/login
2. Coba login dengan email/password salah
3. Lihat error message muncul
4. Login dengan credentials yang benar
5. Centang "Remember Me" untuk test fitur remember
6. Lihat redirect ke dashboard

### Test Manual Logout

1. Dari dashboard, klik tombol Logout
2. Lihat redirect ke login dengan pesan sukses
3. Coba akses http://localhost:8000/dashboard
4. Harus redirect ke login (karena belum login)

### Test Manual Middleware

1. **Test Guest Middleware:**
   - Login terlebih dahulu
   - Coba akses http://localhost:8000/register
   - Harus redirect ke dashboard (karena sudah login)

2. **Test Auth Middleware:**
   - Logout terlebih dahulu
   - Coba akses http://localhost:8000/dashboard
   - Harus redirect ke login (karena belum login)

---

## 🔒 Security Features

### 1. **Password Hashing**
- Menggunakan algoritma bcrypt (Laravel default)
- Password tidak pernah disimpan dalam bentuk plain text
- Hash otomatis melalui `Hash::make()`

### 2. **Password Validation**
Requirement password yang ketat:
```php
Password::min(8)
    ->letters()      // Harus ada huruf
    ->mixedCase()    // Huruf besar dan kecil
    ->numbers()      // Harus ada angka
    ->symbols()      // Harus ada simbol
```

Contoh password valid:
- `Password123!`
- `MyP@ssw0rd`
- `Secure#2024`

Contoh password invalid:
- `password` (tidak ada huruf besar, angka, simbol)
- `PASSWORD` (tidak ada huruf kecil, angka, simbol)
- `Pass123` (kurang dari 8 karakter, tidak ada simbol)

### 3. **CSRF Protection**
- Setiap form menggunakan `@csrf` directive
- Token CSRF divalidasi otomatis oleh Laravel
- Token di-regenerate setelah login/logout

### 4. **Session Management**
- Session ID di-regenerate setelah login (mencegah session fixation)
- Session di-invalidate saat logout
- Remember token untuk fitur "Remember Me"

### 5. **Input Validation**
- Semua input divalidasi sebelum diproses
- Email harus unique di database
- Validasi format email yang benar
- Protection dari SQL Injection (Laravel Eloquent)

### 6. **Middleware Protection**
- `guest` middleware: Mencegah user yang sudah login mengakses halaman login/register
- `auth` middleware: Mencegah user yang belum login mengakses dashboard

### 7. **Error Handling**
- Error messages tidak memberikan informasi sensitif
- Login error generic: "Email atau password salah" (tidak spesifik mana yang salah)

---

## 📝 Custom Error Messages (Bahasa Indonesia)

```php
'name.required' => 'Nama wajib diisi'
'email.required' => 'Email wajib diisi'
'email.email' => 'Format email tidak valid'
'email.unique' => 'Email sudah terdaftar'
'password.required' => 'Password wajib diisi'
'password.confirmed' => 'Konfirmasi password tidak cocok'
```

---

## 🎨 Design Features

### Color Palette
- Primary Gradient: `#ACEB02` → `#8BC900` (Lime/Green) - Background
- Secondary Gradient: `#01343B` → `#023840` (Dark Teal) - Buttons/Accent
- Tertiary: `#7BD404` (Lighter Green) - Alternative
- Background: `#f5f7fa` (Light Gray)
- White: `#ffffff`
- Text Dark: `#01343B`

### Typography
- Font Family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif
- Heading: 28-32px, Bold
- Body: 14-16px, Regular
- Small: 12px

### UI Components
- Rounded corners: 10-20px
- Box shadows untuk depth
- Smooth transitions (0.2-0.3s)
- Hover effects pada buttons
- Responsive design

---

## 🔄 Flow Diagram

```
┌─────────────┐
│   Landing   │
│    (/)      │
└──────┬──────┘
       │
       ▼
┌─────────────┐     Sudah Login?     ┌─────────────┐
│   /login    │ ◄─── Yes ────────────┤  Dashboard  │
└──────┬──────┘                      └──────┬──────┘
       │                                    │
       │ No                                 │
       ▼                                    │
┌─────────────┐                            │
│ Login Form  │                            │
└──────┬──────┘                            │
       │                                    │
       │ Belum punya akun?                 │
       ▼                                    │
┌─────────────┐                            │
│  /register  │                            │
└──────┬──────┘                            │
       │                                    │
       ▼                                    │
┌─────────────┐                            │
│Register Form│                            │
└──────┬──────┘                            │
       │                                    │
       │ Submit                             │
       ▼                                    │
┌─────────────┐                            │
│  Validasi   │                            │
└──────┬──────┘                            │
       │                                    │
       ├── Error ──► Tampilkan Error       │
       │                                    │
       ▼                                    │
   Berhasil                                │
       │                                    │
       ▼                                    │
┌─────────────┐                            │
│ Auto Login  │                            │
└──────┬──────┘                            │
       │                                    │
       └────────────────────────────────────┘
                     │
                     ▼
              ┌─────────────┐
              │  Dashboard  │
              └──────┬──────┘
                     │
                     │ Logout
                     ▼
              ┌─────────────┐
              │   /login    │
              └─────────────┘
```

---

## 📦 Dependencies

Sistem autentikasi ini menggunakan fitur built-in Laravel:

```json
{
    "laravel/framework": "^11.x",
    "illuminate/support": "^11.x",
    "illuminate/auth": "^11.x",
    "illuminate/validation": "^11.x"
}
```

Tidak memerlukan package tambahan!

---

## 🎓 Struktur Kode

```
app/
├── Http/
│   └── Controllers/
│       └── AuthController.php          # Logic autentikasi
└── Models/
    └── User.php                        # Model User (sudah ada)

resources/
└── views/
    ├── auth/
    │   ├── register.blade.php         # Form registrasi
    │   └── login.blade.php            # Form login
    └── dashboard.blade.php            # Dashboard user

routes/
└── web.php                            # Routing aplikasi
```

---

## ✅ Checklist Fitur

- [x] Form registrasi dengan validasi
- [x] Form login dengan validasi
- [x] Password hashing yang aman
- [x] CSRF protection
- [x] Session management
- [x] Remember me functionality
- [x] Auto-login setelah registrasi
- [x] Protected routes (middleware)
- [x] Guest routes (middleware)
- [x] Logout functionality
- [x] Dashboard untuk user
- [x] Error messages dalam Bahasa Indonesia
- [x] Responsive design
- [x] Modern UI dengan gradient
- [x] Password strength validation
- [x] Email uniqueness validation

---

## 🚀 Next Steps (Pengembangan Selanjutnya)

Beberapa fitur yang bisa ditambahkan di masa depan:

1. **Email Verification**
   - Kirim email verifikasi setelah registrasi
   - User harus verifikasi email sebelum bisa login penuh

2. **Forgot Password**
   - Fitur reset password via email
   - Token-based password reset

3. **Profile Management**
   - Edit profile (nama, email)
   - Change password
   - Upload avatar

4. **Two-Factor Authentication (2FA)**
   - Keamanan tambahan dengan OTP
   - Google Authenticator integration

5. **Social Login**
   - Login dengan Google
   - Login dengan Facebook

6. **Rate Limiting**
   - Batasi percobaan login
   - Mencegah brute force attack

7. **Activity Log**
   - Catat aktivitas user
   - Login history
   - IP address tracking

---

## 🐛 Troubleshooting

### Error: "The POST method is not supported"
**Solusi:** Pastikan form menggunakan `@csrf` directive

### Error: "Class 'Hash' not found"
**Solusi:** Import dengan `use Illuminate\Support\Facades\Hash;`

### Error: "Route [login] not defined"
**Solusi:** Pastikan route `login` sudah didefinisikan di `routes/web.php`

### Halaman login tidak bisa diakses
**Solusi:** 
1. Clear cache: `php artisan route:clear`
2. Clear config: `php artisan config:clear`

### Session tidak tersimpan
**Solusi:** 
1. Pastikan `SESSION_DRIVER` di `.env` sudah di-set (default: `file`)
2. Pastikan folder `storage/framework/sessions` ada dan writable

---

## 📞 Support

Jika ada pertanyaan atau masalah, silakan hubungi tim development.

---

**Dibuat dengan ❤️ untuk Product Catalog PPL Project**

*Last Updated: November 12, 2025*
