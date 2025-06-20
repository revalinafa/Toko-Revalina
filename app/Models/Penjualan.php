<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Penjualan extends Model
{
    use HasFactory;

    protected $fillable = [
        'produk_id',
        'jumlah',
        'tanggal',
    ];

    protected $casts = [
        'tanggal' => 'date', // Mengubah tanggal ke objek Carbon secara otomatis
    ];

    /**
     * Get the produk that owns the Penjualan.
     */
    public function produk(): BelongsTo
    {
        return $this->belongsTo(Produk::class);
    }
}