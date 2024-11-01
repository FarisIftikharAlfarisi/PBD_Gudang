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
        Schema::create('inventaris', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ID_Barang');
            $table->foreign('ID_Barang')->references('ID_Barang')->on('barangs')->onDelete('cascade');
            $table->unsignedBigInteger('ID_Karyawan');
            $table->foreign('ID_Karyawan')->references('ID_Karyawan')->on('karyawans')->onDelete('cascade');
            $table->integer('Jumlah_Barang_Aktual');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventaris');
    }
};
