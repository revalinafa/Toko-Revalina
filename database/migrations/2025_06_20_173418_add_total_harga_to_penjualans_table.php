<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('penjualans', function (Blueprint $table) {
        $table->unsignedBigInteger('total_harga')->after('jumlah'); // Atau posisi lain yang Anda inginkan
    });
}

public function down()
{
    Schema::table('penjualans', function (Blueprint $table) {
        $table->dropColumn('total_harga');
    });
}
    
};
