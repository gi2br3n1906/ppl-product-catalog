<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SellerRegistrationController;

// Halaman utama redirect ke login
Route::get('/', function () {
    return redirect()->route('login');
});

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
    
    // Seller Dashboard
    Route::get('/seller/dashboard', function () {
        return view('seller.dashboard');
    })->name('seller.dashboard');
    
    // Admin: Verifikasi Seller
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/seller-registrations', [SellerRegistrationController::class, 'index'])->name('seller-registrations.index');
        Route::get('/seller-registrations/{id}', [SellerRegistrationController::class, 'show'])->name('seller-registrations.show');
        Route::post('/seller-registrations/{id}/approve', [SellerRegistrationController::class, 'approve'])->name('seller-registrations.approve');
        Route::post('/seller-registrations/{id}/reject', [SellerRegistrationController::class, 'reject'])->name('seller-registrations.reject');
    });
});
