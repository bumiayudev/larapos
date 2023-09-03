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
        Schema::create('barang', function (Blueprint $table) {
            $table->string('kd_brg', 20)->primary();
            $table->string('nm_brg', 40);
            $table->bigInteger('hrg_beli');
            $table->bigInteger('hrg_jual');
            $table->integer('jml_brg');
            $table->string('satuan', 20);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang');
    }
};
