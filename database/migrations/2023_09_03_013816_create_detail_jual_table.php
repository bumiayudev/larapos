<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('detail_jual', function (Blueprint $table) {
            $table->string('faktur', 10);
            $table->string('kd_brg', 20);
            $table->string('nm_brg', 40);
            $table->bigInteger('hrg_jual');
            $table->bigInteger('subtotal');
            $table->foreign('faktur')->references('faktur')->on('penjualan');
            $table->foreign('kd_brg')->references('kd_brg')->on('barang');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_jual');
    }
};
