<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InventarisSeeder extends Seeder
{
    public function run()
    {
        DB::table('inventaris')->insert([
            [
                'ID_Barang' => 20, // Barang pertama
                'ID_Karyawan' => 1, // Karyawan yang bertanggung jawab
                'Jumlah_Barang_Aktual' => 20, // Jumlah awal barang
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ID_Barang' => 24, // Barang kedua
                'ID_Karyawan' => 2,
                'Jumlah_Barang_Aktual' => 15,
                'created_at' => now(),
                'updated_at' => now(),
            ]
            // Tambahkan record lain sesuai jumlah barang yang ada
        ]);
    }
}
