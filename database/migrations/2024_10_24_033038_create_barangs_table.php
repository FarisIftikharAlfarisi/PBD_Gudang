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
        Schema::create('barangs', function (Blueprint $table) {
            $table->id('ID_Barang');

            $table->unsignedBigInteger('ID_Kategori');
            $table->foreign('ID_Kategori')->references('ID_Kategori')->on('kategoris')->onDelete('cascade');

            $table->unsignedBigInteger('ID_Rak');
            $table->foreign('ID_Rak')->references('ID_Rak')->on('raks')->onDelete('cascade');

            $table->string('Nama_Barang', 255);
            $table->text('Deskripsi');
            $table->string('Satuan', 50);
            $table->decimal('Harga_Pokok', 10, 2);
            $table->decimal('Harga_Jual', 10, 2);
            $table->string('Kode_Part', 100);
            $table->string('Merek', 100);
            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};
