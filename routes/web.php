<?php

// routes/web.php
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController; // Optional
use App\Http\Controllers\Auth\ResetPasswordController; // Optional

// Autentikasi
Route::middleware('guest')->group(function () {
    // Login
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    // Register
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

    // Forgot Password (Opsional)
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');
});


Route::middleware('auth')->group(function () {
    // Logout (biasanya POST, tapi bisa GET juga untuk kemudahan testing)
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout'); // Disarankan POST
    Route::get('/logout', [LoginController::class, 'logout']); // Alternatif GET untuk logout

    // Rute dashboard atau halaman yang hanya bisa diakses setelah login
    Route::get('/dashboard', function () {
        return view('dashboard'); // Anda perlu membuat view ini
    })->name('dashboard');

    // Tambahkan rute resource yang membutuhkan autentikasi di sini
    // Contoh:
    Route::resource('diagnosas', App\Http\Controllers\DiagnosaController::class);
    Route::resource('articles', App\Http\Controllers\ArticleController::class);

    // Rute yang hanya bisa diakses oleh admin
    Route::middleware('admin')->group(function () { // 'admin' adalah middleware custom yang akan kita buat
        Route::resource('penyakits', App\Http\Controllers\PenyakitController::class);
        Route::resource('gejalas', App\Http\Controllers\GejalaController::class);
        Route::resource('kasuses', App\Http\Controllers\KasusController::class);
        Route::resource('solusis', App\Http\Controllers\SolusiController::class);
        Route::resource('roles', App\Http\Controllers\RoleController::class);
        Route::resource('users', App\Http\Controllers\UserController::class);
    });
});