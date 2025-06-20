<?php

namespace App\Livewire\Superadmin\Laporan;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Penjualan;
use App\Models\Produk;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB; // <-- TAMBAHKAN BARIS INI

#[Layout('layouts.app')]
class Harian extends Component
{
    public $selectedDate;

    public function mount()
    {
        $this->selectedDate = Carbon::today()->toDateString();
    }

    public function render()
    {
        try {
            $date = Carbon::parse($this->selectedDate);
        } catch (\Exception $e) {
            $date = Carbon::today();
            $this->selectedDate = $date->toDateString();
        }

        $totalNilaiPenjualan = Penjualan::whereDate('tanggal', $date)
                                        ->join('produks', 'penjualans.produk_id', '=', 'produks.id')
                                        ->sum(DB::raw('penjualans.jumlah * produks.harga'));

        $stokProduk = Produk::orderBy('nama_produk', 'asc')->get();

        $data = [
            'title' => 'Laporan Harian',
            'totalNilaiPenjualan' => $totalNilaiPenjualan,
            'stokProduk' => $stokProduk,
            'currentDate' => $date->translatedFormat('l, d F Y'),
        ];

        return view('livewire.superadmin.laporan.harian', $data);
    }

    public function updatedSelectedDate()
    {
        // Livewire akan otomatis memanggil render() lagi
    }
}