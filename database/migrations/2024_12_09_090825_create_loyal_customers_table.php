<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function Laravel\Prompts\table;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('loyal_customers', function (Blueprint $table) {
            $table->id();
            $table->string('Nama_Pelanggan');
            $table->string('No_Telepon');
            $table->string('Tanggal_Berlangganan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loyal_customers');
    }
};
