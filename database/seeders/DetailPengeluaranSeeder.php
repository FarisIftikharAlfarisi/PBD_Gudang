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
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'ID_Pengeluaran' => 2, // Sesuaikan dengan ID_Supplier yang ada
                'ID_Barang' => 2, // Sesuaikan dengan ID_Barang yang ada
                'qty' => 5,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
