<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StokLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'produk_id',
        'jenis', // 'masuk' atau 'keluar'
        'jumlah',
        'tanggal',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    /**
     * Get the produk that owns the StokLog.
     */
    public function produk(): BelongsTo
    {
        return $this->belongsTo(Produk::class);
    }
}