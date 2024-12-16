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
                'ID_Barang' => 1, // Barang pertama
                'Jumlah_Barang_Aktual' => 10, // Jumlah awal barang
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ID_Barang' => 2, // Barang kedua
                'Jumlah_Barang_Aktual' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ]
            // Tambahkan record lain sesuai jumlah barang yang ada
        ]);
    }
}
