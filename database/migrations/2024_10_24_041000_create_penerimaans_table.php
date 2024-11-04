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
        Schema::create('penerimaans', function (Blueprint $table) {
            $table->id('ID_Penerimaan');
            $table->string('No_Faktur', 100);
            $table->date('Tanggal_Penerimaan');

            $table->unsignedBigInteger('ID_Barang');
            $table->foreign('ID_Barang')->references('ID_Barang')->on('barangs')->onDelete('cascade');

            $table->unsignedBigInteger('ID_Supplier');
            $table->foreign('ID_Supplier')->references('ID_Supplier')->on('suppliers')->onDelete('cascade');

            $table->unsignedBigInteger('ID_Karyawan')->nullable();
            $table->foreign('ID_Karyawan')->references('ID_Karyawan')->on('karyawans')->onDelete('cascade');

            $table->integer('Jumlah');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penerimaans');
    }
};
