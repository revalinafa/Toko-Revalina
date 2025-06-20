<?php

namespace App\Livewire\Superadmin\Kategori;

use App\Models\Kategori;
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

    public $nama_kategori,
           $kategori_id; // Properti untuk menyimpan ID kategori yang sedang diedit/dihapus

    // Listener untuk event JavaScript (opsional, karena kebanyakan dipicu oleh data-toggle="modal")
    protected $listeners = [
        'closeCreateKategoriModal',
        'closeEditKategoriModal',
        'closeDeleteKategoriModal'
    ];

    public function render()
    {
        $query = Kategori::query();

        if ($this->search) {
            $query->where('nama_kategori', 'like', '%' . $this->search . '%');
        }

        $data = [
            'title' => 'Data Kategori',
            'kategoris' => $query->orderBy('nama_kategori', 'asc')->paginate($this->paginate),
        ];

        return view('livewire.superadmin.kategori.index', $data);
    }

    // Reset properti untuk form tambah kategori
    public function create()
    {
        $this->resetValidation();
        $this->reset(['nama_kategori', 'kategori_id']);
    }

    // Menyimpan kategori baru
    public function store()
    {
        $this->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategoris,nama_kategori',
        ],
        [
            'nama_kategori.required' => 'Nama kategori tidak boleh kosong.',
            'nama_kategori.unique' => 'Nama kategori sudah ada.',
        ]);

        try {
            Kategori::create([
                'nama_kategori' => $this->nama_kategori,
            ]);

            $this->dispatch('success', 'Kategori berhasil ditambahkan.');
            $this->dispatch('closeCreateKategoriModal');
            $this->resetValidation();
            $this->reset(['nama_kategori', 'kategori_id']);
        } catch (\Exception $e) {
            $this->dispatch('error', 'Gagal menambahkan kategori: ' . $e->getMessage());
        }
    }

    // Mengisi form edit dengan data kategori yang dipilih
    public function edit($id)
    {
        $kategori = Kategori::findOrFail($id);
        $this->kategori_id = $kategori->id;
        $this->nama_kategori = $kategori->nama_kategori;
        $this->dispatch('showEditKategoriModal'); // Membuka modal via JS
    }

    // Memperbarui kategori
    public function update()
    {
        $this->resetValidation();
        $kategori = Kategori::findOrFail($this->kategori_id); // Gunakan $this->kategori_id

        $this->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategoris,nama_kategori,' . $kategori->id,
        ],
        [
            'nama_kategori.required' => 'Nama kategori tidak boleh kosong.',
            'nama_kategori.unique' => 'Nama kategori sudah ada.',
        ]);

        try {
            $kategori->update([
                'nama_kategori' => $this->nama_kategori,
            ]);

            $this->dispatch('success', 'Kategori berhasil diperbarui.');
            $this->dispatch('closeEditKategoriModal');
            $this->resetValidation();
            $this->reset(['nama_kategori', 'kategori_id']);
        } catch (\Exception $e) {
            $this->dispatch('error', 'Gagal memperbarui kategori: ' . $e->getMessage());
        }
    }

    // Menyiapkan ID kategori untuk modal konfirmasi hapus
    public function deleteConfirmation($id)
    {
        $this->kategori_id = $id; // Simpan ID kategori yang akan dihapus
    }

    // Menghapus kategori
    public function destroy()
    {
        if (!$this->kategori_id) {
            $this->dispatch('error', 'Tidak ada kategori yang dipilih untuk dihapus.');
            return;
        }

        try {
            $kategori = Kategori::findOrFail($this->kategori_id);
            $kategori->delete();

            $this->dispatch('success', 'Kategori berhasil dihapus.');
            $this->dispatch('closeDeleteKategoriModal');
            $this->reset('kategori_id'); // Reset ID kategori setelah dihapus
        } catch (\Exception $e) {
            $this->dispatch('error', 'Gagal menghapus kategori: ' . $e->getMessage());
        }
    }
}