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
        // Drop the foreign key constraint from the correct table (detail_jual)
        Schema::table('detail_jual', function (Blueprint $table) {
            $table->dropForeign('detail_jual_faktur_foreign');
        });

        // Change the column on the penjualan table
        Schema::table('detail_jual', function (Blueprint $table) {
            $table->string('faktur', 100)->change();
        });

        // Re-add the foreign key constraint to the detail_jual table
        Schema::table('detail_jual', function (Blueprint $table) {
            $table->foreign('faktur')->references('faktur')->on('penjualan')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the foreign key constraint (for rollback) from the correct table (detail_jual)
        Schema::table('detail_jual', function (Blueprint $table) {
            $table->dropForeign('detail_jual_faktur_foreign');
        });

        // Reverse the column change on the penjualan table
        Schema::table('detail_jual', function (Blueprint $table) {
            $table->string('faktur', 10)->change(); // Change back to original length
        });

        // Re-add the foreign key constraint (for rollback) to the detail_jual table
        Schema::table('detail_jual', function (Blueprint $table) {
            $table->foreign('faktur')->references('faktur')->on('penjualan')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }
};
