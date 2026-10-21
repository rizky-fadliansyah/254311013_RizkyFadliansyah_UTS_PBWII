<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PenjualController;
use App\Http\Controllers\ResponController;
use App\Http\Controllers\TambahUlasanController;


// 1. Public / Guest Routes (Beranda & Browsing Penjual)
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::prefix('ulasan')->group(function () {
    Route::get('/{id}', [TambahUlasanController::class, 'create'])->name('ulasan.create');
    Route::post('/', [TambahUlasanController::class, 'store'])->name('ulasan.store');
});

// 2. Authentication Routes (Khusus Tamu / Unauthenticated)
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
});

// 3. Authenticated Routes (Khusus Penjual Terautentikasi)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

    // Dashboard & Profile Penjual
    Route::get('/homePenjual', [PenjualController::class, 'dashboard'])->name('homePenjual');
    Route::get('/penjual/edit', [PenjualController::class, 'edit'])->name('penjual.edit');
    Route::post('/simpan-penjual', [PenjualController::class, 'store'])->name('penjual.store');
    
    // Ulasan & Respon Penjual
    Route::get('/penjual/ulasan', [PenjualController::class, 'ulasan'])->name('penjual.ulasan');
    Route::post('/respon', [ResponController::class, 'store'])->name('respon.store');
});

Route::prefix('penjual')->group(function () {
    Route::get('/{id}', [PenjualController::class, 'show'])->name('penjual.detail');
});