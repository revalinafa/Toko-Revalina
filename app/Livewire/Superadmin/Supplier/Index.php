<?php

namespace App\Livewire\Superadmin\Supplier;

use App\Models\Supplier;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')] 

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $paginate = 10;
    public $search = '';

    public $nama_supplier,
           $supplier_id; // Properti untuk menyimpan ID supplier yang sedang diedit/dihapus

    // Listener untuk event JavaScript (opsional)
    protected $listeners = [
        'closeCreateSupplierModal',
        'closeEditSupplierModal',
        'closeDeleteSupplierModal'
    ];

    public function render()
    {
        $query = Supplier::query();

        if ($this->search) {
            $query->where('nama_supplier', 'like', '%' . $this->search . '%');
        }

        $data = [
            'title' => 'Data Supplier',
            'suppliers' => $query->orderBy('nama_supplier', 'asc')->paginate($this->paginate),
        ];

        return view('livewire.superadmin.supplier.index', $data);
    }

    // Reset properti untuk form tambah supplier
    public function create()
    {
        $this->resetValidation();
        $this->reset(['nama_supplier', 'supplier_id']);
    }

    // Menyimpan supplier baru
    public function store()
    {
        $this->validate([
            'nama_supplier' => 'required|string|max:255|unique:suppliers,nama_supplier',
        ],
        [
            'nama_supplier.required' => 'Nama supplier tidak boleh kosong.',
            'nama_supplier.unique' => 'Nama supplier sudah ada.',
        ]);

        try {
            Supplier::create([
                'nama_supplier' => $this->nama_supplier,
            ]);

            $this->dispatch('success', 'Supplier berhasil ditambahkan.');
            $this->dispatch('closeCreateSupplierModal');
            $this->resetValidation();
            $this->reset(['nama_supplier', 'supplier_id']);
        } catch (\Exception $e) {
            $this->dispatch('error', 'Gagal menambahkan supplier: ' . $e->getMessage());
        }
    }

    // Mengisi form edit dengan data supplier yang dipilih
    public function edit($id)
    {
        $supplier = Supplier::findOrFail($id);
        $this->supplier_id = $supplier->id;
        $this->nama_supplier = $supplier->nama_supplier;
        $this->dispatch('showEditSupplierModal'); // Membuka modal via JS
    }

    // Memperbarui supplier
    public function update()
    {
        $this->resetValidation();
        $supplier = Supplier::findOrFail($this->supplier_id); // Gunakan $this->supplier_id

        $this->validate([
            'nama_supplier' => 'required|string|max:255|unique:suppliers,nama_supplier,' . $supplier->id,
        ],
        [
            'nama_supplier.required' => 'Nama supplier tidak boleh kosong.',
            'nama_supplier.unique' => 'Nama supplier sudah ada.',
        ]);

        try {
            $supplier->update([
                'nama_supplier' => $this->nama_supplier,
            ]);

            $this->dispatch('success', 'Supplier berhasil diperbarui.');
            $this->dispatch('closeEditSupplierModal');
            $this->resetValidation();
            $this->reset(['nama_supplier', 'supplier_id']);
        } catch (\Exception $e) {
            $this->dispatch('error', 'Gagal memperbarui supplier: ' . $e->getMessage());
        }
    }

    // Menyiapkan ID supplier untuk modal konfirmasi hapus
    public function deleteConfirmation($id)
    {
        $this->supplier_id = $id; // Simpan ID supplier yang akan dihapus
    }

    // Menghapus supplier
    public function destroy()
    {
        if (!$this->supplier_id) {
            $this->dispatch('error', 'Tidak ada supplier yang dipilih untuk dihapus.');
            return;
        }

        try {
            $supplier = Supplier::findOrFail($this->supplier_id);
            $supplier->delete();

            $this->dispatch('success', 'Supplier berhasil dihapus.');
            $this->dispatch('closeDeleteSupplierModal');
            $this->reset('supplier_id'); // Reset ID supplier setelah dihapus
        } catch (\Exception $e) {
            $this->dispatch('error', 'Gagal menghapus supplier: ' . $e->getMessage());
        }
    }
}