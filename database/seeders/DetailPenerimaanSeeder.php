<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DetailPenerimaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('detail_penerimaans')->insert([
            [
                'ID_Penerimaan' => 1, // Sesuaikan dengan ID_Supplier yang ada
                'ID_Barang' => 3, // Sesuaikan dengan ID_Barang yang ada
                'qty' => 20,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'ID_Penerimaan' => 2, // Sesuaikan dengan ID_Supplier yang ada
                'ID_Barang' => 3, // Sesuaikan dengan ID_Barang yang ada
                'qty' => 10,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
