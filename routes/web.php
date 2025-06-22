<?php

use Illuminate\Support\Facades\Route; // Penting: Tambahkan ini
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController; // Optional, pastikan sudah ada jika ingin menggunakan
use App\Http\Controllers\Auth\ResetPasswordController; // Optional, pastikan sudah ada jika ingin menggunakan
use App\Http\Controllers\ArticleController; // Import ArticleController
use App\Http\Controllers\DiagnosaController; // Import DiagnosaController
use App\Http\Controllers\PenyakitController; // Import PenyakitController
use App\Http\Controllers\GejalaController;   // Import GejalaController
use App\Http\Controllers\KasusController;    // Import KasusController
use App\Http\Controllers\SolusiController;   // Import SolusiController
use App\Http\Controllers\RoleController;     // Import RoleController
use App\Http\Controllers\UserController;     // Import UserController

// Rute untuk halaman utama (welcome)
// Ketika user mengakses URL root (misal: yourdomain.com/ atau localhost/yourproject/public/)
Route::get('/', function () {
    return view('welcome'); // Menampilkan resources/views/welcome.blade.php
})->name('welcome'); // Memberi nama rute untuk memudahkan referensi

// Rute Autentikasi untuk pengguna yang BELUM login
Route::middleware('guest')->group(function () {
    // Login
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    // Registrasi
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

    // Forgot Password (Opsional: pastikan controller dan viewnya ada)
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');
});

// Rute yang memerlukan autentikasi (untuk pengguna yang SUDAH login)
Route::middleware('auth')->group(function () {
    // Logout (Disarankan menggunakan POST untuk keamanan, GET hanya untuk kemudahan testing/debugging)
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/logout', [LoginController::class, 'logout']); // Alternatif GET, pertimbangkan untuk dihapus di produksi

    // Rute dashboard
    Route::get('/dashboard', function () {
        return view('dashboard'); // Pastikan Anda memiliki file view 'dashboard.blade.php'
    })->name('dashboard');

    // Rute resource yang hanya bisa diakses setelah login (pengguna biasa & admin)
    Route::resource('diagnosas', DiagnosaController::class);
    Route::resource('articles', ArticleController::class);

    // Rute yang hanya bisa diakses oleh admin
    // Pastikan middleware 'admin' sudah terdaftar di app/Http/Kernel.php
    Route::middleware('admin')->group(function () {
        Route::resource('penyakits', PenyakitController::class);
        Route::resource('gejalas', GejalaController::class);
        Route::resource('kasuses', KasusController::class);
        Route::resource('solusis', SolusiController::class);
        Route::resource('roles', RoleController::class);
        Route::resource('users', UserController::class);
    });
});