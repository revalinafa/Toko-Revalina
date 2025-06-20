<?php

namespace App\Livewire\Superadmin\Penjualan;

use App\Models\Penjualan;
use App\Models\Produk; // Perlu untuk dropdown produk
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout; // Pastikan ini ada

#[Layout('layouts.app')]
class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $paginate = 10;
    public $search = '';

    // Properti untuk form Penjualan
    public $produk_id,
           $jumlah,
           $tanggal,
           $penjualan_id; // Digunakan untuk menyimpan ID penjualan yang sedang diedit/dihapus

    public $produks = []; // Untuk dropdown produk

    // Listener untuk event JavaScript
    protected $listeners = [
        'closeCreatePenjualanModal',
        'closeEditPenjualanModal',
        'closeDeletePenjualanModal'
    ];

    public function mount()
    {
        $this->loadProdukData();
    }

    public function loadProdukData()
    {
        $this->produks = Produk::select('id', 'nama_produk')->orderBy('nama_produk')->get();
    }

    public function render()
    {
        $query = Penjualan::query();

        if ($this->search) {
            $query->whereHas('produk', function($q) {
                $q->where('nama_produk', 'like', '%' . $this->search . '%');
            })
            ->orWhere('jumlah', 'like', '%' . $this->search . '%')
            ->orWhere('tanggal', 'like', '%' . $this->search . '%');
        }

        $data = [
            'title' => 'Data Penjualan',
            'penjualans' => $query->with('produk') // Eager load relasi produk
                                 ->orderBy('tanggal', 'desc')
                                 ->paginate($this->paginate),
            'produks' => $this->produks, // Kirim ke view untuk dropdown
        ];

        return view('livewire.superadmin.penjualan.index', $data);
    }

    public function create()
    {
        $this->resetValidation();
        $this->reset(['produk_id', 'jumlah', 'tanggal', 'penjualan_id']);
        $this->loadProdukData(); // Refresh dropdown
    }

    public function store()
    {
        $this->validate([
            'produk_id' => 'required|exists:produks,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal' => 'required|date',
        ],
        [
            'produk_id.required' => 'Produk tidak boleh kosong.',
            'produk_id.exists' => 'Produk tidak valid.',
            'jumlah.required' => 'Jumlah tidak boleh kosong.',
            'jumlah.integer' => 'Jumlah harus berupa bilangan bulat.',
            'jumlah.min' => 'Jumlah minimal 1.',
            'tanggal.required' => 'Tanggal tidak boleh kosong.',
            'tanggal.date' => 'Format tanggal tidak valid.',
        ]);

        try {
            Penjualan::create([
                'produk_id' => $this->produk_id,
                'jumlah' => $this->jumlah,
                'tanggal' => $this->tanggal,
            ]);

            $this->dispatch('success', 'Penjualan berhasil ditambahkan.');
            $this->dispatch('closeCreatePenjualanModal');
            $this->resetValidation();
            $this->reset(['produk_id', 'jumlah', 'tanggal', 'penjualan_id']);
        } catch (\Exception $e) {
            $this->dispatch('error', 'Gagal menambahkan penjualan: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $penjualan = Penjualan::findOrFail($id);
        $this->penjualan_id = $penjualan->id;
        $this->produk_id = $penjualan->produk_id;
        $this->jumlah = $penjualan->jumlah;
        $this->tanggal = $penjualan->tanggal->format('Y-m-d'); // Format tanggal untuk input date HTML

        $this->loadProdukData(); // Refresh dropdown
        $this->dispatch('showEditPenjualanModal');
    }

    public function update()
    {
        $this->resetValidation();
        $penjualan = Penjualan::findOrFail($this->penjualan_id);

        $this->validate([
            'produk_id' => 'required|exists:produks,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal' => 'required|date',
        ],
        [
            'produk_id.required' => 'Produk tidak boleh kosong.',
            'produk_id.exists' => 'Produk tidak valid.',
            'jumlah.required' => 'Jumlah tidak boleh kosong.',
            'jumlah.integer' => 'Jumlah harus berupa bilangan bulat.',
            'jumlah.min' => 'Jumlah minimal 1.',
            'tanggal.required' => 'Tanggal tidak boleh kosong.',
            'tanggal.date' => 'Format tanggal tidak valid.',
        ]);

        try {
            $penjualan->update([
                'produk_id' => $this->produk_id,
                'jumlah' => $this->jumlah,
                'tanggal' => $this->tanggal,
            ]);

            $this->dispatch('success', 'Penjualan berhasil diperbarui.');
            $this->dispatch('closeEditPenjualanModal');
            $this->resetValidation();
            $this->reset(['produk_id', 'jumlah', 'tanggal', 'penjualan_id']);
        } catch (\Exception $e) {
            $this->dispatch('error', 'Gagal memperbarui penjualan: ' . $e->getMessage());
        }
    }

    public function deleteConfirmation($id)
    {
        $this->penjualan_id = $id;
    }

    public function destroy()
    {
        if (!$this->penjualan_id) {
            $this->dispatch('error', 'Tidak ada penjualan yang dipilih untuk dihapus.');
            return;
        }

        try {
            $penjualan = Penjualan::findOrFail($this->penjualan_id);
            $penjualan->delete();

            $this->dispatch('success', 'Penjualan berhasil dihapus.');
            $this->dispatch('closeDeletePenjualanModal');
            $this->reset('penjualan_id');
        } catch (\Exception $e) {
            $this->dispatch('error', 'Gagal menghapus penjualan: ' . $e->getMessage());
        }
    }
}