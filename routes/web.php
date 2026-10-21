<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PenjualController;
use App\Http\Controllers\ResponController;
use App\Http\Controllers\TambahUlasanController;
use App\Http\Controllers\KategoriController;


// 1. Public / Guest Routes (Bisa Diakses Siapa Saja)
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::prefix('penjual')->group(function () {
    Route::get('/{id}', [PenjualController::class, 'show'])->name('penjual.detail');
});

Route::prefix('ulasan')->group(function () {
    Route::get('/{id}', [TambahUlasanController::class, 'create'])->name('ulasan.create');
    Route::post('/', [TambahUlasanController::class, 'store'])->name('ulasan.store');
});

// 2. Guest Routes (Khusus Pengunjung yang Belum Login)
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
});

// 3. Authenticated Routes (Harus Login)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

    // --- AREA PENJUAL ---
    Route::get('/homePenjual', [PenjualController::class, 'dashboard'])->name('homePenjual');
    Route::get('/penjual/edit', [PenjualController::class, 'edit'])->name('penjual.edit');
    Route::post('/simpan-penjual', [PenjualController::class, 'store'])->name('penjual.store');
    Route::get('/penjual/ulasan', [PenjualController::class, 'ulasan'])->name('penjual.ulasan');
    Route::post('/respon', [ResponController::class, 'store'])->name('respon.store');

    // --- AREA ADMIN (Kelola Kategori) ---
    Route::prefix('admin')->group(function () {
        Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
        Route::post('/kategori', [KategoriController::class, 'store'])->name('kategori.store');
        Route::delete('/kategori/{id}', [KategoriController::class, 'destroy'])->name('kategori.destroy');
        Route::get('/kategori/{id}/edit', [KategoriController::class, 'edit'])->name('kategori.edit');
        Route::put('/kategori/{id}', [KategoriController::class, 'update'])->name('kategori.update');
    });
});