<?php

namespace App\Livewire\Superadmin\Produk;

use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Supplier;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\DB;

#[Layout('layouts.app')]
class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $paginate = 10;
    public $search = '';

    // Properti baru untuk filter
    public $filterKategoriId = ''; // Default 'semua' atau kosong
    public $filterSupplierId = ''; // Default 'semua' atau kosong

    public $nama_produk,
           $harga,
           $stok,
           $kategori_id,
           $supplier_id,
           $produk_id;

    public $kategoris = [];
    public $suppliers = [];

    protected $listeners = [
        'closeCreateModal',
        'closeEditModal',
        'closeDeleteModal'
    ];

    public function mount()
    {
        $this->loadDropdownData();
    }

    public function loadDropdownData()
    {
        $this->kategoris = Kategori::select('id', 'nama_kategori')->orderBy('nama_kategori')->get();
        $this->suppliers = Supplier::select('id', 'nama_supplier')->orderBy('nama_supplier')->get();
    }

    public function render()
    {
        $query = Produk::query();

        // Penerapan filter pencarian
        if ($this->search) {
            $query->where('nama_produk', 'like', '%' . $this->search . '%')
                  ->orWhere('harga', 'like', '%' . $this->search . '%')
                  ->orWhere('stok', 'like', '%' . $this->search . '%')
                  ->orWhereHas('kategori', function($q) {
                      $q->where('nama_kategori', 'like', '%' . $this->search . '%');
                  })
                  ->orWhereHas('supplier', function($q) {
                      $q->where('nama_supplier', 'like', '%' . $this->search . '%');
                  });
        }

        // Penerapan filter kategori
        if ($this->filterKategoriId && $this->filterKategoriId !== '') { // Pastikan bukan string kosong
            $query->where('kategori_id', $this->filterKategoriId);
        }

        // Penerapan filter supplier
        if ($this->filterSupplierId && $this->filterSupplierId !== '') { // Pastikan bukan string kosong
            $query->where('supplier_id', $this->filterSupplierId);
        }

        $data = [
            'title' => 'Data Produk',
            'produks' => $query->with(['kategori', 'supplier'])
                               ->orderBy('nama_produk', 'asc')
                               ->paginate($this->paginate),
            'kategoris' => $this->kategoris,
            'suppliers' => $this->suppliers,
        ];

        return view('livewire.superadmin.produk.index', $data);
    }

    // Metode reset dan CRUD lainnya tetap sama seperti sebelumnya
    // (create, store, edit, update, deleteConfirmation, destroy)
    // Saya tidak menyertakannya lagi di sini untuk brevity, anggap sama dengan yang Anda miliki
    // atau yang saya berikan di respons sebelumnya untuk Produk.

    // Contoh metode create (pastikan memanggil loadDropdownData)
    public function create(){
        $this->resetValidation();
        $this->reset([
            'nama_produk', 'harga', 'stok', 'kategori_id', 'supplier_id', 'produk_id'
        ]);
        $this->loadDropdownData(); // Memuat data dropdown saat membuat
    }

    // Metode store, edit, update, deleteConfirmation, destroy juga sama
    // Anda bisa copy-paste dari komponen Produk/Index.php yang sudah lengkap sebelumnya.
    // Pastikan update() tidak mempengaruhi stok di sini.
    // Pastikan destroy() tidak mempengaruhi stok di sini.
    // Stok akan dikelola oleh Penjualan dan Stok Log.

    // Contoh: Method store
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

    // ... sisanya dari fungsi edit, update, deleteConfirmation, destroy
    // Pastikan di edit juga ada loadDropdownData();
    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        $this->produk_id = $produk->id;
        $this->nama_produk = $produk->nama_produk;
        $this->harga = $produk->harga;
        $this->stok = $produk->stok;
        $this->kategori_id = $produk->kategori_id;
        $this->supplier_id = $produk->supplier_id;

        $this->loadDropdownData();
        $this->dispatch('showEditModal');
    }

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

    public function deleteConfirmation($id)
    {
        $this->produk_id = $id;
    }

    public function destroy()
    {
        if (!$this->produk_id) {
            $this->dispatch('error', 'Tidak ada produk yang dipilih untuk dihapus.');
            return;
        }

        try {
            $produk = Produk::findOrFail($this->produk_id);
            $produk->delete();

            $this->dispatch('success', 'Produk berhasil dihapus.');
            $this->dispatch('closeDeleteModal');
            $this->reset('produk_id');
        } catch (\Exception $e) {
            $this->dispatch('error', 'Gagal menghapus produk: ' . $e->getMessage());
        }
    }
}