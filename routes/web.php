<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\DiagnosaController;
use App\Http\Controllers\PenyakitController;
use App\Http\Controllers\GejalaController;
use App\Http\Controllers\KasusController;
use App\Http\Controllers\SolusiController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController; // <--- BARIS BARU UNTUK DASHBOARD ADMIN

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/logout', [LoginController::class, 'logout']);

    // Diagnosa resource is now directly under 'auth' middleware,
    Route::resource('diagnosas', DiagnosaController::class);
    Route::resource('articles', ArticleController::class);

    // Grouping admin routes under 'admin' middleware
    Route::middleware('admin')->group(function () {
        // <--- UBAH BAGIAN INI UNTUK DASHBOARD ADMIN
       Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        // PASTIKAN ANDA MENGHAPUS ATAU MENGGANTI ROUTE LAMA YANG SEPERTI INI:
        // Route::get('/dashboard', function () { return view('dashboard'); })->name('dashboard');
        // KARENA INI AKAN BENTROK ATAU TIDAK AKAN MENGGUNAKAN CONTROLLER BARU ANDA

        Route::resource('penyakits', PenyakitController::class);
        Route::resource('gejalas', GejalaController::class);
        Route::resource('kasuses', KasusController::class);
        Route::resource('solusis', SolusiController::class);
        Route::resource('roles', RoleController::class);
        Route::resource('users', UserController::class);
    });
});