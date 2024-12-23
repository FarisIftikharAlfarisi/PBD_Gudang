<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DetailPengeluaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('detail_pengeluarans')->insert([
            [
                'ID_Pengeluaran' => 1, // Sesuaikan dengan ID_Supplier yang ada
                'ID_Barang' => 1, // Sesuaikan dengan ID_Barang yang ada
                'qty' => 10,
                'Harga_Jual' => 75000,
                'Diskon' => 5000,
                'Total' => 700000,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'ID_Pengeluaran' => 2, // Sesuaikan dengan ID_Supplier yang ada
                'ID_Barang' => 2, // Sesuaikan dengan ID_Barang yang ada
                'qty' => 5,
                'Harga_Jual' => 50000,
                'Diskon' => 5000,
                'Total' => 225000,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
