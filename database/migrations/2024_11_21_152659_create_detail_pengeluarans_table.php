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
        Schema::create('detail_pengeluarans', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('ID_Pengeluaran');
            $table->unsignedBigInteger('ID_Barang');
            $table->integer('qty');
            $table->decimal('Harga_Jual');
            $table->decimal('Diskon');
            $table->decimal('Total');
            $table->timestamps();
        
            $table->foreign('ID_Pengeluaran')->references('ID_Pengeluaran')->on('pengeluarans')->onDelete('cascade');
            $table->foreign('ID_Barang')->references('ID_Barang')->on('barangs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_pengeluarans');
    }
};
