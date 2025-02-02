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
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->string('Nomor_Nota',100)->nullable();
            $table->integer('ID_Barang')->nullable();
            $table->integer('Jumlah')->nullable();
            $table->integer('Harga_Jual')->nullable();
            $table->integer('Diskon_Per_Items')->nullable();
            $table->integer('Harga_Akhir')->nullable();
            $table->integer('Subtotal')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
