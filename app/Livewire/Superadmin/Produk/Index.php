<?php

namespace App\Livewire\Superadmin\Produk;

use App\Models\Produk; // Pastikan ini benar
use App\Models\Kategori; // Tambahkan import Kategori
use App\Models\Supplier; // Tambahkan import Supplier
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB; // Untuk transaksi atau debugging jika diperlukan
use Livewire\Attributes\Layout;

#[Layout('layouts.app')] 

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    // Properti untuk filter dan pagination
    public $paginate = 10;
    public $search = '';

    // Properti untuk form Tambah/Edit Produk
    public $nama_produk,
           $harga,
           $stok,
           $kategori_id,
           $supplier_id,
           $produk_id; // Digunakan untuk menyimpan ID produk yang sedang diedit/dihapus

    // Properti untuk menyimpan daftar kategori dan supplier
    // Akan diisi saat render atau saat dibutuhkan untuk dropdown
    public $kategoris = [];
    public $suppliers = [];

    // Listener untuk event dari JavaScript
    protected $listeners = [
        'showCreateModal', // Jika ingin memicu modal create dari Livewire
        'showEditModal',   // Untuk membuka modal edit
        'closeCreateModal',
        'closeEditModal',
        'closeDeleteModal'
    ];

    // Metode `mount` akan dijalankan sekali saat komponen diinisialisasi
    public function mount()
    {
        $this->loadDropdownData();
    }

    // Metode untuk memuat data kategori dan supplier
    public function loadDropdownData()
    {
        $this->kategoris = Kategori::select('id', 'nama_kategori')->get(); // Sesuaikan 'nama_kategori' dengan nama kolom di tabel kategori Anda
        $this->suppliers = Supplier::select('id', 'nama_supplier')->get(); // Sesuaikan 'nama_supplier' dengan nama kolom di tabel supplier Anda
    }


    public function render()
    {
        $query = Produk::query();

        // Penerapan filter pencarian
        if ($this->search) {
            $query->where('nama_produk', 'like', '%' . $this->search . '%')
                  ->orWhere('harga', 'like', '%' . $this->search . '%')
                  ->orWhere('stok', 'like', '%' . $this->search . '%')
                  // Cari berdasarkan nama kategori/supplier jika relasi di-eager load
                  ->orWhereHas('kategori', function($q) {
                      $q->where('nama_kategori', 'like', '%' . $this->search . '%'); // Sesuaikan 'nama_kategori'
                  })
                  ->orWhereHas('supplier', function($q) {
                      $q->where('nama_supplier', 'like', '%' . $this->search . '%'); // Sesuaikan 'nama_supplier'
                  });
        }

        $data = [
            'title' => 'Data Produk',
            'produks' => $query->with(['kategori', 'supplier']) // Eager load relasi untuk menampilkan nama
                               ->orderBy('nama_produk', 'asc')
                               ->paginate($this->paginate),
            'kategoris' => $this->kategoris, // Kirim ke view untuk dropdown
            'suppliers' => $this->suppliers, // Kirim ke view untuk dropdown
        ];

        return view('livewire.superadmin.produk.index', $data);
    }

    // Reset properti untuk form tambah produk
    public function create()
    {
        $this->resetValidation();
        $this->reset([
            'nama_produk', 'harga', 'stok', 'kategori_id', 'supplier_id', 'produk_id'
        ]);
        // Pastikan dropdown diisi ulang jika data berubah
        $this->loadDropdownData();
    }

    // Menyimpan produk baru
    public function store()
    {
        $this->validate([
            'nama_produk' => 'required|string|max:255|unique:produks,nama_produk',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'kategori_id' => 'required|exists:kategoris,id',
            'supplier_id' => 'required|exists:suppliers,id',
        ],
        [
            'nama_produk.required' => 'Nama produk tidak boleh kosong.',
            'nama_produk.unique' => 'Nama produk sudah ada.',
            'harga.required' => 'Harga tidak boleh kosong.',
            'harga.numeric' => 'Harga harus berupa angka.',
            'harga.min' => 'Harga tidak boleh negatif.',
            'stok.required' => 'Stok tidak boleh kosong.',
            'stok.integer' => 'Stok harus berupa bilangan bulat.',
            'stok.min' => 'Stok tidak boleh negatif.',
            'kategori_id.required' => 'Kategori tidak boleh kosong.',
            'kategori_id.exists' => 'Kategori tidak valid.',
            'supplier_id.required' => 'Supplier tidak boleh kosong.',
            'supplier_id.exists' => 'Supplier tidak valid.',
        ]);

        try {
            Produk::create([
                'nama_produk' => $this->nama_produk,
                'harga' => $this->harga,
                'stok' => $this->stok,
                'kategori_id' => $this->kategori_id,
                'supplier_id' => $this->supplier_id,
            ]);

            $this->dispatch('success', 'Produk berhasil ditambahkan.');
            $this->dispatch('closeCreateModal');
            $this->resetValidation();
            $this->reset([
                'nama_produk', 'harga', 'stok', 'kategori_id', 'supplier_id', 'produk_id'
            ]);
        } catch (\Exception $e) {
            $this->dispatch('error', 'Gagal menambahkan produk: ' . $e->getMessage());
        }
    }

    // Mengisi form edit dengan data produk yang dipilih
    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        $this->produk_id = $produk->id;
        $this->nama_produk = $produk->nama_produk;
        $this->harga = $produk->harga;
        $this->stok = $produk->stok;
        $this->kategori_id = $produk->kategori_id;
        $this->supplier_id = $produk->supplier_id;

        // Pastikan dropdown diisi ulang jika data berubah
        $this->loadDropdownData();

        $this->dispatch('showEditModal');
    }

    // Memperbarui produk
    public function update($id)
    {
        $this->resetValidation();
        $produk = Produk::findOrFail($id);

        $this->validate([
            'nama_produk' => 'required|string|max:255|unique:produks,nama_produk,' . $produk->id,
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'kategori_id' => 'required|exists:kategoris,id',
            'supplier_id' => 'required|exists:suppliers,id',
        ],
        [
            'nama_produk.required' => 'Nama produk tidak boleh kosong.',
            'nama_produk.unique' => 'Nama produk sudah ada.',
            'harga.required' => 'Harga tidak boleh kosong.',
            'harga.numeric' => 'Harga harus berupa angka.',
            'harga.min' => 'Harga tidak boleh negatif.',
            'stok.required' => 'Stok tidak boleh kosong.',
            'stok.integer' => 'Stok harus berupa bilangan bulat.',
            'stok.min' => 'Stok tidak boleh negatif.',
            'kategori_id.required' => 'Kategori tidak boleh kosong.',
            'kategori_id.exists' => 'Kategori tidak valid.',
            'supplier_id.required' => 'Supplier tidak boleh kosong.',
            'supplier_id.exists' => 'Supplier tidak valid.',
        ]);

        try {
            $produk->update([
                'nama_produk' => $this->nama_produk,
                'harga' => $this->harga,
                'stok' => $this->stok,
                'kategori_id' => $this->kategori_id,
                'supplier_id' => $this->supplier_id,
            ]);

            $this->dispatch('success', 'Produk berhasil diperbarui.');
            $this->dispatch('closeEditModal');
            $this->resetValidation();
            $this->reset([
                'nama_produk', 'harga', 'stok', 'kategori_id', 'supplier_id', 'produk_id'
            ]);
        } catch (\Exception $e) {
            $this->dispatch('error', 'Gagal memperbarui produk: ' . $e->getMessage());
        }
    }

    // Menyiapkan ID produk untuk modal konfirmasi hapus
    public function deleteConfirmation($id)
    {
        $this->produk_id = $id; // Simpan ID produk yang akan dihapus
        // Modal akan dibuka via data-target di button HTML
    }

    // Menghapus produk
    public function destroy()
    {
        // Pastikan ada produk_id yang dipilih
        if (!$this->produk_id) {
            $this->dispatch('error', 'Tidak ada produk yang dipilih untuk dihapus.');
            return;
        }

        try {
            $produk = Produk::findOrFail($this->produk_id);
            $produk->delete();

            $this->dispatch('success', 'Produk berhasil dihapus.');
            $this->dispatch('closeDeleteModal');
            $this->reset('produk_id'); // Reset ID produk setelah dihapus
        } catch (\Exception $e) {
            $this->dispatch('error', 'Gagal menghapus produk: ' . $e->getMessage());
        }
    }
}