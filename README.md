# Toko-Revalina
Manajemen Produk Toko menggunakan Laravel 12 dan Livewire 3

Manajemen Produk Toko
Tabel:
1. produk(id, nama_produk, harga, stok, kategori_id, supplier_id)
2. kategori(id, nama_kategori)
3. supplier(id, nama_supplier, alamat, telepon)
4. penjualan(id, produk_id, jumlah, tanggal)
5. stok_log(id, produk_id, jenis, jumlah, tanggal)

Relasi:
1. produk → belongsTo kategori, supplier
2. penjualan → belongsTo produk
3. stok_log → belongsTo produk


