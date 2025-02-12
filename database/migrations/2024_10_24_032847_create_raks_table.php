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
        Schema::create('raks', function (Blueprint $table) {
            $table->id('ID_Rak');
            $table->string('Nomor_Rak', 50);
            $table->text('Lokasi_Rak');
            $table->string('Status_Rak', 50);
            $table->unsignedBigInteger('ID_Gudang');
            $table->foreign('ID_Gudang')->references('ID_Gudang')->on('gudangs')->onDelete('cascade');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('raks');
    }
};
