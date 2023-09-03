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
        Schema::create('penjualan', function (Blueprint $table) {
            $table->string('faktur',10)->primary();
            $table->date('tanggal');
            $table->integer('item');
            $table->bigInteger('total');
            $table->bigInteger('dibayar');
            $table->bigInteger('kembali');
            $table->string('kd_ptg', 8);
            $table->foreign('kd_ptg')->references('kd_ptg')->on('petugas')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualan');
    }
};
