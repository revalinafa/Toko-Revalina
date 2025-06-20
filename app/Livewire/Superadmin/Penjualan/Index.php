<?php

namespace App\Livewire\Superadmin\Penjualan;

use Livewire\Component;
use App\Models\Produk;
use App\Models\Penjualan;
use App\Models\StokLog;
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

    public $produk_id,
           $jumlah,
           $tanggal,
           $penjualan_id;

    public $produks = [];

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
        $this->produks = Produk::select('id', 'nama_produk', 'stok', 'harga')->orderBy('nama_produk')->get(); // Ambil harga juga
    }

    public function render()
    {
        // ... (kode render() tidak berubah, seperti yang sudah Anda miliki) ...
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
            'penjualans' => $query->with('produk')
                                 ->orderBy('tanggal', 'desc')
                                 ->paginate($this->paginate),
            'produks' => $this->produks,
        ];

        return view('livewire.superadmin.penjualan.index', $data);
    }

    public function create()
    {
        $this->resetValidation();
        $this->reset(['produk_id', 'jumlah', 'tanggal', 'penjualan_id']);
        $this->tanggal = now()->format('Y-m-d');
        $this->loadProdukData();
    }

    public function store()
    {
        $this->validate([
            'produk_id' => 'required|exists:produks,id',
            'jumlah' => 'required|numeric|min:1',
            'tanggal' => 'required|date',
        ],
        [
            'produk_id.required' => 'Produk tidak boleh kosong.',
            'produk_id.exists' => 'Produk tidak valid.',
            'jumlah.required' => 'Jumlah tidak boleh kosong.',
            'jumlah.numeric' => 'Jumlah harus berupa angka.',
            'jumlah.min' => 'Jumlah minimal 1.',
            'tanggal.required' => 'Tanggal tidak boleh kosong.',
            'tanggal.date' => 'Format tanggal tidak valid.',
        ]);

        $produk = Produk::find($this->produk_id);

        if ($produk->stok < $this->jumlah) {
            $this->dispatch('error', 'Stok produk ' . $produk->nama_produk . ' tidak mencukupi untuk penjualan. Stok tersedia: ' . $produk->stok);
            return;
        }

        $totalHarga = $produk->harga * $this->jumlah; // <-- HITUNG TOTAL HARGA

        DB::transaction(function () use ($produk, $totalHarga) { // <-- LEWATKAN $totalHarga
            Penjualan::create([
                'produk_id' => $this->produk_id,
                'jumlah' => $this->jumlah,
                'tanggal' => $this->tanggal,
                'total_harga' => $totalHarga, // <-- SIMPAN TOTAL HARGA
            ]);

            $produk->decrement('stok', $this->jumlah);

            StokLog::create([
                'produk_id' => $this->produk_id,
                'jenis' => 'keluar',
                'jumlah' => $this->jumlah,
                'tanggal' => $this->tanggal,
            ]);
        });

        $this->dispatch('success', 'Penjualan berhasil disimpan dan stok diperbarui.');
        $this->dispatch('closeCreatePenjualanModal');
        $this->resetValidation();
        $this->reset(['produk_id', 'jumlah', 'tanggal', 'penjualan_id']);
    }

    public function edit($id)
    {
        $penjualan = Penjualan::findOrFail($id);
        $this->penjualan_id = $penjualan->id;
        $this->produk_id = $penjualan->produk_id;
        $this->jumlah = $penjualan->jumlah;
        $this->tanggal = $penjualan->tanggal->format('Y-m-d');

        $this->loadProdukData();
        $this->dispatch('showEditPenjualanModal');
    }

    public function update()
    {
        $this->resetValidation();
        $penjualan = Penjualan::findOrFail($this->penjualan_id);

        $this->validate([
            'produk_id' => 'required|exists:produks,id',
            'jumlah' => 'required|numeric|min:1',
            'tanggal' => 'required|date',
        ],
        [
            'produk_id.required' => 'Produk tidak boleh kosong.',
            'produk_id.exists' => 'Produk tidak valid.',
            'jumlah.required' => 'Jumlah tidak boleh kosong.',
            'jumlah.numeric' => 'Jumlah harus berupa angka.',
            'jumlah.min' => 'Jumlah minimal 1.',
            'tanggal.required' => 'Tanggal tidak boleh kosong.',
            'tanggal.date' => 'Format tanggal tidak valid.',
        ]);

        $produkBaru = Produk::find($this->produk_id);
        // Penting: Logika update stok dan log jika jumlah atau produk_id berubah
        // Ini adalah bagian kompleks. Untuk saat ini, kita hanya update data penjualan
        // tanpa membalikkan/menyesuaikan stok. Jika jumlah penjualan diubah,
        // penyesuaian stok harus dilakukan secara manual atau melalui fitur Stok Log terpisah
        // atau Anda perlu logika yang lebih rumit di sini.

        // Jika Anda ingin mengupdate total_harga berdasarkan harga produk saat ini saat update:
        $newTotalHarga = $produkBaru->harga * $this->jumlah; // <-- HITUNG ULANG TOTAL HARGA

        try {
            $penjualan->update([
                'produk_id' => $this->produk_id,
                'jumlah' => $this->jumlah,
                'tanggal' => $this->tanggal,
                'total_harga' => $newTotalHarga, // <-- SIMPAN TOTAL HARGA YANG DIUPDATE
            ]);

            $this->dispatch('success', 'Data penjualan berhasil diperbarui.');
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
            $produk = Produk::find($penjualan->produk_id);

            DB::transaction(function () use ($penjualan, $produk) {
                if ($produk) {
                    $produk->increment('stok', $penjualan->jumlah);
                }

                StokLog::create([
                    'produk_id' => $penjualan->produk_id,
                    'jenis' => 'masuk',
                    'jumlah' => $penjualan->jumlah,
                    'tanggal' => now(),
                    'keterangan' => 'Pengembalian stok dari penjualan dihapus ID: ' . $penjualan->id
                ]);

                $penjualan->delete();
            });

            $this->dispatch('success', 'Penjualan berhasil dihapus dan stok dikembalikan.');
            $this->dispatch('closeDeletePenjualanModal');
            $this->reset('penjualan_id');
        } catch (\Exception $e) {
            $this->dispatch('error', 'Gagal menghapus penjualan: ' . $e->getMessage());
        }
    }
}