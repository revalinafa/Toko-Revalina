<?php
use App\Models\Produk;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penjualans', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Produk::class)->constrained()->onDelete('cascade');
            $table->integer('jumlah');
            $table->unsignedBigInteger('total_harga'); // Total harga saat transaksi
            $table->timestamp('tanggal');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penjualans');
    }
};