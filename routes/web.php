<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\penjualController;
use App\Http\Controllers\TambahUlasanController;
use App\Models\penjual;
use App\Models\Kategori;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// 1. Route Beranda / Dashboard Pembeli
Route::get('/', function (Request $request) {
    $query = penjual::with(['ulasan', 'kategori']);
    if ($request->filled('cari')) {
        $search = $request->input('cari');
        $query->where(function ($q) use ($search) {
            $q->where('Nama_Penjual', 'like', "%{$search}%")
              ->orWhere('Alamat_Penjual', 'like', "%{$search}%");
        });
    }
    if ($request->filled('kategori')) {
        $kategoriId = $request->input('kategori');
        $query->where('Id_Kategori', $kategoriId);
    }
    $penjualList = $query->get();
    $kategoriList = Kategori::all();
    return view('dashboard', compact('penjualList', 'kategoriList'));
})->name('dashboard');

// 2. Auth Routes Guest (Login & Register khusus Penjual)
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
});

// 3. Auth Routes (Khusus Penjual setelah Login)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
    
    // Halaman Utama / Dashboard Penjual
    Route::get('/homePenjual', function () {
        $penjual = penjual::find(Auth::id());
        return view('homePenjual', compact('penjual'));
    })->name('homePenjual');

    // Halaman Form Edit Data Penjual
    Route::get('/penjual/edit', function () {
        $penjual = penjual::find(Auth::id());
        $kategoriList = Kategori::all();
        return view('editPenjual', compact('penjual', 'kategoriList'));
    })->name('penjual.edit');

    // Halaman Lihat Ulasan khusus Penjual
    Route::get('/penjual/ulasan', function () {
        $penjual = penjual::find(Auth::id());
        return view('ViewUlasan', compact('penjual'));
    })->name('penjual.ulasan');

    // Proses Simpan / Update Data Penjual
    Route::post('simpan-penjual', [penjualController::class, 'store'])->name('penjual.store');
});

// 4. Public Routes (Akses Umum Pembeli)
Route::get('/penjual/{id}', function ($id) {
    $penjual = penjual::findOrFail($id);
    return view('detail', compact('penjual'));
})->name('penjual.detail');

Route::get('/ulasan/{id}', function ($id) {
    $penjual = penjual::findOrFail($id);
    return view('formulasan', compact('penjual'));
})->name('ulasan.create');

use App\Http\Controllers\ResponController;

Route::post('/respon', [ResponController::class, 'store'])->name('respon.store');

Route::post('/ulasan', [TambahUlasanController::class, 'store'])->name('ulasan.store');