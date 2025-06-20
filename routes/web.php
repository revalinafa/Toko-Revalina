<?php

use Illuminate\Support\Facades\Route;

// Import Livewire components
use App\Livewire\Superadmin\User\Index as UserIndex;
use App\Livewire\Superadmin\Produk\Index as ProdukIndex;
use App\Livewire\Superadmin\Kategori\Index as KategoriIndex;
use App\Livewire\Superadmin\Supplier\Index as SupplierIndex;
use App\Livewire\Superadmin\Penjualan\Index as PenjualanIndex; // Tambahkan ini
use App\Livewire\Superadmin\StokLog\Index as StokLogIndex;     // Tambahkan ini


Route::get('/', function () {
    return view('welcome');
});

Route::prefix('superadmin')->name('superadmin.')->group(function () {
    Route::get('user', UserIndex::class)->name('user.index');
    Route::get('produk', ProdukIndex::class)->name('produk.index');
    Route::get('kategori', KategoriIndex::class)->name('kategori.index');
    Route::get('supplier', SupplierIndex::class)->name('supplier.index');

    // Ubah Route::view menjadi Route::get untuk Penjualan
    Route::get('penjualan', PenjualanIndex::class)->name('penjualan.index');

    // Ubah Route::view menjadi Route::get untuk Stok Log
    Route::get('stok_log', StokLogIndex::class)->name('stok_log.index'); // Sesuaikan URL jika perlu 'stok-log'
});