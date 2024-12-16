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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('Nomor_Nota',100);
            $table->string('Tanggal_Pembelian');
            $table->string('Metode_Pembayaran')->nullable();
            $table->string('Uang_Masuk')->nullable();
            $table->string('Kembalian')->nullable();
            $table->integer('Total_Pembayaran')->nullable();
            $table->string('ID_Pembeli')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
