<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Import Livewire components
use App\Livewire\Superadmin\User\Index as UserIndex;
use App\Livewire\Superadmin\Produk\Index as ProdukIndex;
use App\Livewire\Superadmin\Kategori\Index as KategoriIndex;
use App\Livewire\Superadmin\Supplier\Index as SupplierIndex;
use App\Livewire\Superadmin\Penjualan\Index as PenjualanIndex;
use App\Livewire\Superadmin\StokLog\Index as StokLogIndex;
use App\Livewire\Superadmin\Laporan\Harian as LaporanHarian; // Tambahkan ini

// Import Livewire Components untuk Auth
use App\Livewire\Auth\Login as AuthLogin;
use App\Livewire\Auth\Register as AuthRegister;


Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('login', AuthLogin::class)->name('login');
    Route::get('register', AuthRegister::class)->name('register');
});

Route::middleware('auth')->group(function () {
    Route::post('logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/login');
    })->name('logout');
});


Route::prefix('superadmin')->name('superadmin.')->middleware('auth')->group(function () {
    // Route untuk Dashboard
    Route::get('dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Route untuk Manajemen User
    Route::get('user', UserIndex::class)->name('user.index');

    // Route untuk Manajemen Produk
    Route::get('produk', ProdukIndex::class)->name('produk.index');

    // Route untuk Manajemen Kategori
    Route::get('kategori', KategoriIndex::class)->name('kategori.index');

    // Route untuk Manajemen Supplier
    Route::get('supplier', SupplierIndex::class)->name('supplier.index');

    // Route untuk Penjualan
    Route::get('penjualan', PenjualanIndex::class)->name('penjualan.index');

    // Route untuk Stok Log
    Route::get('stok_log', StokLogIndex::class)->name('stok_log.index');

    // TAMBAHKAN ROUTE UNTUK LAPORAN HARIAN INI
    Route::get('laporan/harian', LaporanHarian::class)->name('laporan.harian');
});