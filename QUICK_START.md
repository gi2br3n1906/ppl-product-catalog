# 🚀 Quick Start - Autentikasi

## Setup Cepat

### 1. Jalankan Migration
```bash
php artisan migrate
```

### 2. Jalankan Server
```bash
php artisan serve
```

### 3. Akses Aplikasi
- **Registrasi:** http://localhost:8000/register
- **Login:** http://localhost:8000/login
- **Dashboard:** http://localhost:8000/dashboard

---

## 📝 Test Akun

Untuk testing, buat akun dengan data berikut:

```
Nama: Test User
Email: test@example.com
Password: Test123!@#
Konfirmasi: Test123!@#
```

Password harus memiliki:
- ✅ Minimal 8 karakter
- ✅ Huruf besar (A-Z)
- ✅ Huruf kecil (a-z)
- ✅ Angka (0-9)
- ✅ Simbol (!@#$%, dll)

---

## 📂 File yang Dibuat

```
app/Http/Controllers/AuthController.php      # Controller autentikasi
resources/views/auth/register.blade.php      # Halaman registrasi
resources/views/auth/login.blade.php         # Halaman login
resources/views/dashboard.blade.php          # Dashboard user
routes/web.php                               # Routes (diupdate)
AUTH_README.md                               # Dokumentasi lengkap
QUICK_START.md                               # File ini
```

---

## 🔥 Fitur Utama

✅ Registrasi dengan validasi ketat  
✅ Login dengan remember me  
✅ Auto-login setelah registrasi  
✅ Dashboard untuk user  
✅ Logout yang aman  
✅ Password hashing (bcrypt)  
✅ CSRF protection  
✅ Session management  
✅ Middleware protection  
✅ UI modern & responsive  
✅ Error messages Bahasa Indonesia  

---

## 🛡️ Routes

### Guest Only (belum login):
- `GET  /register` - Form registrasi
- `POST /register` - Proses registrasi
- `GET  /login` - Form login
- `POST /login` - Proses login

### Auth Only (sudah login):
- `GET  /dashboard` - Dashboard
- `POST /logout` - Logout

---

## 💡 Tips

1. **Lupa logout?** Tutup browser atau hapus session manual
2. **Error validasi?** Periksa kembali format password
3. **Email sudah terdaftar?** Gunakan email lain atau login
4. **Lupa password?** Fitur reset belum tersedia (coming soon)

---

Untuk dokumentasi lengkap, baca **AUTH_README.md**
