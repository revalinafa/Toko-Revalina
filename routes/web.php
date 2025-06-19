<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::view('superadmin/user','superadmin.user.index')->name('superadmin.user.index');

Route::view('superadmin/produk/index','superadmin.produk.index')->name('superadmin.produk.index');

Route::view('superadmin/kategori/index','superadmin.kategori.index')->name('superadmin.kategori.index');

Route::view('superadmin/supplier/index','superadmin.supplier.index')->name('superadmin.supplier.index');

Route::view('superadmin/penjualan/index','superadmin.penjualan.index')->name('superadmin.penjualan.index');

Route::view('superadmin/stok_log/index','superadmin.stok_log.index')->name('superadmin.stok_log.index');