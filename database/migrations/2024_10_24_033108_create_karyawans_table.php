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
        Schema::create('karyawans', function (Blueprint $table) {
            $table->id('ID_Karyawan');
            $table->string('Nomor_karyawan',80);
            $table->string('email',80);
            $table->string('password')->default('suksesjdm1');
            $table->string('Nama_Karyawan', 255);
            $table->text('Alamat');
            $table->string('Nomor_Telepon', 15);
            $table->string('Jabatan', 100);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('karyawans');
    }
};
