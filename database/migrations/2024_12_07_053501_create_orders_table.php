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
            $table->string('Nomor_Nota');
            $table->string('Tanggal_Pembelian');
            $table->string('Metode_Pembayaran');
            $table->string('Uang_Masuk');
            $table->string('Kembalian');
            $table->integer('Total_Pembayaran');
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
