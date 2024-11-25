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
        Schema::create('detail_penerimaans', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('ID_Penerimaan');
            $table->unsignedBigInteger('ID_Barang');
            $table->integer('qty');
            $table->timestamps();
        
            $table->foreign('ID_Penerimaan')->references('ID_Penerimaan')->on('penerimaans')->onDelete('cascade');
            $table->foreign('ID_Barang')->references('ID_Barang')->on('barangs')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_penerimaans');
    }
};
