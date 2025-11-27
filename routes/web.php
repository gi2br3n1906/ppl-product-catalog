<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SellerRegistrationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;

// Halaman utama (Catalog) - Public, semua bisa akses
Route::get('/', [ProductController::class, 'index'])->name('catalog');
Route::get('/product/{product}', [ProductController::class, 'show'])->name('product.show');

// Route Authentication (Guest only - belum login)
Route::middleware('guest')->group(function () {
    // Registrasi Seller
    Route::get('/seller/register', [SellerRegistrationController::class, 'showRegistrationForm'])->name('seller.register.form');
    Route::post('/seller/register', [SellerRegistrationController::class, 'register'])->name('seller.register');
    Route::get('/seller/registration-success', [SellerRegistrationController::class, 'registrationSuccess'])->name('seller.registration.success');
    
    // Login
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Route untuk user yang sudah login (Protected routes)
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Add to Cart (requires auth - Login to buy)
    Route::post('/cart/add', [CartController::class, 'store'])->name('cart.add');
    
    // Seller Dashboard
    Route::get('/seller/dashboard', function () {
        return view('seller.dashboard');
    })->name('seller.dashboard');

    // Seller: Kelola Produk (Halaman & Simpan Baru)
    Route::get('/seller/kelola-produk', [ProductController::class, 'kelolaProduk'])->name('seller.kelola-produk');
    Route::post('/seller/kelola-produk', [ProductController::class, 'storeProduk'])->name('seller.kelola-produk.store'); // Note: name saya perjelas agar unik
    
    // Seller: Kelola Produk (Update & Delete Produk)
    Route::put('/seller/kelola-produk/{id}', [ProductController::class, 'updateProduk'])->name('seller.produk.update');
    Route::delete('/seller/kelola-produk/{id}', [ProductController::class, 'destroyProduk'])->name('seller.produk.destroy');

    // Seller: Hapus Satu Gambar Spesifik (Fitur Baru)
    Route::delete('/seller/image/{id}', [ProductController::class, 'deleteImage'])->name('seller.image.delete');

    // API Endpoints untuk Dashboard
    Route::prefix('api/dashboard')->name('api.dashboard.')->group(function () {
        Route::get('/sales', [DashboardController::class, 'getSalesData'])->name('sales');
        Route::get('/stock', [DashboardController::class, 'getStockData'])->name('stock');
        Route::get('/rating', [DashboardController::class, 'getRatingData'])->name('rating');
        Route::get('/location', [DashboardController::class, 'getLocationData'])->name('location');
        Route::get('/products', [DashboardController::class, 'getProducts'])->name('products');
        Route::get('/years', [DashboardController::class, 'getYears'])->name('years');
        Route::get('/low-stock', [DashboardController::class, 'getLowStockProducts'])->name('low-stock');
    });
    
    // Admin: Verifikasi Seller
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/seller-registrations', [SellerRegistrationController::class, 'index'])->name('seller-registrations.index');
        Route::get('/seller-registrations/{id}', [SellerRegistrationController::class, 'show'])->name('seller-registrations.show');
        Route::post('/seller-registrations/{id}/approve', [SellerRegistrationController::class, 'approve'])->name('seller-registrations.approve');
        Route::post('/seller-registrations/{id}/reject', [SellerRegistrationController::class, 'reject'])->name('seller-registrations.reject');
    });
});