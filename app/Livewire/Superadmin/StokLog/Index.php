<?php

namespace App\Livewire\Superadmin\StokLog;

use App\Models\StokLog;
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

    // Properti untuk form Stok Log
    public $produk_id,
           $jenis, // 'masuk' atau 'keluar'
           $jumlah,
           $tanggal,
           $stok_log_id; // Digunakan untuk menyimpan ID stok log yang sedang diedit/dihapus

    public $produks = []; // Untuk dropdown produk
    public $jenisOptions = [ // Opsi untuk jenis stok
        'masuk' => 'Masuk',
        'keluar' => 'Keluar'
    ];

    // Listener untuk event JavaScript
    protected $listeners = [
        'closeCreateStokLogModal',
        'closeEditStokLogModal',
        'closeDeleteStokLogModal'
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
        $query = StokLog::query();

        if ($this->search) {
            $query->whereHas('produk', function($q) {
                $q->where('nama_produk', 'like', '%' . $this->search . '%');
            })
            ->orWhere('jenis', 'like', '%' . $this->search . '%')
            ->orWhere('jumlah', 'like', '%' . $this->search . '%')
            ->orWhere('tanggal', 'like', '%' . $this->search . '%');
        }

        $data = [
            'title' => 'Data Stok Log',
            'stokLogs' => $query->with('produk') // Eager load relasi produk
                                 ->orderBy('tanggal', 'desc')
                                 ->paginate($this->paginate),
            'produks' => $this->produks, // Kirim ke view untuk dropdown
            'jenisOptions' => $this->jenisOptions, // Kirim ke view untuk dropdown
        ];

        return view('livewire.superadmin.stok-log.index', $data); // Perhatikan 'stok-log'
    }

    public function create()
    {
        $this->resetValidation();
        $this->reset(['produk_id', 'jenis', 'jumlah', 'tanggal', 'stok_log_id']);
        $this->loadProdukData(); // Refresh dropdown
    }

    public function store()
    {
        $this->validate([
            'produk_id' => 'required|exists:produks,id',
            'jenis' => 'required|in:masuk,keluar',
            'jumlah' => 'required|integer|min:1',
            'tanggal' => 'required|date',
        ],
        [
            'produk_id.required' => 'Produk tidak boleh kosong.',
            'produk_id.exists' => 'Produk tidak valid.',
            'jenis.required' => 'Jenis stok tidak boleh kosong.',
            'jenis.in' => 'Jenis stok tidak valid.',
            'jumlah.required' => 'Jumlah tidak boleh kosong.',
            'jumlah.integer' => 'Jumlah harus berupa bilangan bulat.',
            'jumlah.min' => 'Jumlah minimal 1.',
            'tanggal.required' => 'Tanggal tidak boleh kosong.',
            'tanggal.date' => 'Format tanggal tidak valid.',
        ]);

        try {
            StokLog::create([
                'produk_id' => $this->produk_id,
                'jenis' => $this->jenis,
                'jumlah' => $this->jumlah,
                'tanggal' => $this->tanggal,
            ]);

            $this->dispatch('success', 'Stok log berhasil ditambahkan.');
            $this->dispatch('closeCreateStokLogModal');
            $this->resetValidation();
            $this->reset(['produk_id', 'jenis', 'jumlah', 'tanggal', 'stok_log_id']);
        } catch (\Exception $e) {
            $this->dispatch('error', 'Gagal menambahkan stok log: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $stokLog = StokLog::findOrFail($id);
        $this->stok_log_id = $stokLog->id;
        $this->produk_id = $stokLog->produk_id;
        $this->jenis = $stokLog->jenis;
        $this->jumlah = $stokLog->jumlah;
        $this->tanggal = $stokLog->tanggal->format('Y-m-d'); // Format tanggal untuk input date HTML

        $this->loadProdukData(); // Refresh dropdown
        $this->dispatch('showEditStokLogModal');
    }

    public function update()
    {
        $this->resetValidation();
        $stokLog = StokLog::findOrFail($this->stok_log_id);

        $this->validate([
            'produk_id' => 'required|exists:produks,id',
            'jenis' => 'required|in:masuk,keluar',
            'jumlah' => 'required|integer|min:1',
            'tanggal' => 'required|date',
        ],
        [
            'produk_id.required' => 'Produk tidak boleh kosong.',
            'produk_id.exists' => 'Produk tidak valid.',
            'jenis.required' => 'Jenis stok tidak boleh kosong.',
            'jenis.in' => 'Jenis stok tidak valid.',
            'jumlah.required' => 'Jumlah tidak boleh kosong.',
            'jumlah.integer' => 'Jumlah harus berupa bilangan bulat.',
            'jumlah.min' => 'Jumlah minimal 1.',
            'tanggal.required' => 'Tanggal tidak boleh kosong.',
            'tanggal.date' => 'Format tanggal tidak valid.',
        ]);

        try {
            $stokLog->update([
                'produk_id' => $this->produk_id,
                'jenis' => $this->jenis,
                'jumlah' => $this->jumlah,
                'tanggal' => $this->tanggal,
            ]);

            $this->dispatch('success', 'Stok log berhasil diperbarui.');
            $this->dispatch('closeEditStokLogModal');
            $this->resetValidation();
            $this->reset(['produk_id', 'jenis', 'jumlah', 'tanggal', 'stok_log_id']);
        } catch (\Exception $e) {
            $this->dispatch('error', 'Gagal memperbarui stok log: ' . $e->getMessage());
        }
    }

    public function deleteConfirmation($id)
    {
        $this->stok_log_id = $id;
    }

    public function destroy()
    {
        if (!$this->stok_log_id) {
            $this->dispatch('error', 'Tidak ada stok log yang dipilih untuk dihapus.');
            return;
        }

        try {
            $stokLog = StokLog::findOrFail($this->stok_log_id);
            $stokLog->delete();

            $this->dispatch('success', 'Stok log berhasil dihapus.');
            $this->dispatch('closeDeleteStokLogModal');
            $this->reset('stok_log_id');
        } catch (\Exception $e) {
            $this->dispatch('error', 'Gagal menghapus stok log: ' . $e->getMessage());
        }
    }
}