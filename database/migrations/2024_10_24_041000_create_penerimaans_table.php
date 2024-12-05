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

            $table->unsignedBigInteger('ID_Supplier');
            $table->foreign('ID_Supplier')->references('ID_Supplier')->on('suppliers')->onDelete('cascade');

            $table->integer('jumlah_jenis_barang');
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
