# CampusMarket - Product Catalog

Proyek Perangkat Lunak - Platform marketplace untuk seller di lingkungan kampus.

## 📋 Deskripsi

CampusMarket adalah platform marketplace yang memungkinkan seller untuk mendaftarkan toko mereka dan menjual produk di lingkungan kampus. Sistem ini memiliki fitur verifikasi manual oleh admin untuk memastikan kualitas seller yang bergabung.

## ✨ Fitur Utama

### Untuk Calon Seller
- Registrasi toko dengan data lengkap (nama toko, deskripsi, data PIC, alamat)
- Upload dokumen identitas (foto PIC dan KTP)
- Notifikasi status verifikasi (pending/approved/rejected)

### Untuk Admin
- Dashboard verifikasi registrasi seller
- Review detail pendaftar dengan dokumen lengkap
- Approve atau reject pendaftaran dengan alasan
- Manajemen seller yang terdaftar

### Untuk Seller (Approved)
- Dashboard seller (dalam pengembangan)
- Manajemen produk (coming soon)

## 🛠️ Tech Stack

- **Framework**: Laravel 11.x
- **Database**: MySQL
- **Frontend**: Blade Template, CSS
- **Authentication**: Laravel Auth
- **File Storage**: Laravel Storage (Public Disk)

## 📦 Instalasi & Setup

### Prerequisites
- PHP >= 8.2
- Composer
- MySQL
- Node.js & NPM

### Langkah Instalasi

1. **Clone Repository**
   ```bash
   git clone <repository-url>
   cd ppl-product-catalog
   ```

2. **Install Dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Setup Environment**
   ```bash
   cp .env.example .env
   ```
   
   Edit file `.env` dan sesuaikan konfigurasi database:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=campusmarket
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. **Generate Application Key**
   ```bash
   php artisan key:generate
   ```

5. **Jalankan Migration**
   ```bash
   php artisan migrate
   ```

6. **Create Storage Link**
   ```bash
   php artisan storage:link
   ```

7. **Buat Admin Account**
   ```bash
   php artisan tinker
   ```
   Lalu jalankan:
   ```php
   $admin = new App\Models\User();
   $admin->name = 'Admin';
   $admin->email = 'admin@campusmarket.com';
   $admin->password = bcrypt('admin123');
   $admin->role = 'admin';
   $admin->save();
   exit
   ```

8. **Jalankan Development Server**
   ```bash
   php artisan serve
   ```
   
   Akses aplikasi di: `http://127.0.0.1:8000`

### Menambahkan Produk demo (optional)
Jika ingin mengisi katalog dengan sample data:

```bash
php artisan migrate
php artisan db:seed
php artisan storage:link
```

Perintah di atas akan membuat migrasi, memasukkan sample data (Product seeder) dan membuat symbolic link ke `public/storage` sehingga gambar produk dapat diakses.

## 👤 Default Credentials

**Admin:**
- Email: `admin@campusmarket.com`
- Password: `admin123`

## 🎨 Color Scheme

- Primary Dark: `#01343B`
- Primary Light: `#ACEB02`
- Background: `#FFFFFF`

## 📁 Struktur Project

```
├── app/
│   ├── Http/Controllers/
│   │   ├── AuthController.php              # Login & logout
│   │   └── SellerRegistrationController.php # Registrasi & verifikasi seller
│   └── Models/
│       ├── User.php                         # Model user (admin & seller)
│       └── SellerRegistration.php           # Model registrasi seller
├── database/
│   └── migrations/
│       ├── create_users_table.php
│       ├── create_seller_registrations_table.php
│       └── add_role_to_users_table.php
├── resources/
│   └── views/
│       ├── auth/
│       │   └── login.blade.php              # Halaman login
│       ├── seller/
│       │   ├── register.blade.php           # Form registrasi seller
│       │   ├── registration-success.blade.php
│       │   └── dashboard.blade.php          # Dashboard seller
│       └── admin/
│           └── seller-registrations/
│               ├── index.blade.php          # List registrasi
│               └── show.blade.php           # Detail & verifikasi
└── routes/
    └── web.php                              # Route definitions
```

## 🔐 Role & Permission

- **Admin**: Akses ke dashboard admin untuk verifikasi seller
- **Seller**: Akses ke dashboard seller setelah approved

## 👥 Tim Pengembang

Proyek Perangkat Lunak - Semester 5

## 📄 License

This project is for educational purposes as part of Software Engineering course.
