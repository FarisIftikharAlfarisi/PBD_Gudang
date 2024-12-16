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
        Schema::create('pengeluarans', function (Blueprint $table) {
            $table->id('ID_Pengeluaran');
            $table->string('No_Faktur', 100);
            $table->date('Tanggal_Pengeluaran');

            $table->unsignedBigInteger('ID_Karyawan');
            $table->foreign('ID_Karyawan')->references('ID_Karyawan')->on('karyawans')->onDelete('cascade');
            $table->string('Nama_Penerima');
            $table->string('Tujuan', 255);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengeluarans');
    }
};
