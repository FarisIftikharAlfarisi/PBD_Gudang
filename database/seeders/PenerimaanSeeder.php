<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenerimaanSeeder extends Seeder
{
    public function run()
    {
        DB::table('penerimaans')->insert([
            [
                'No_Faktur' => 'FKT-101-2024',
                'Tanggal_Penerimaan' => '2024-10-05',
                'ID_Barang' => 3, // Sesuaikan dengan ID_Barang yang ada
                'ID_Supplier' => 1, // Sesuaikan dengan ID_Supplier yang ada
                'Jumlah' => 20,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'No_Faktur' => 'FKT-102-2024',
                'Tanggal_Penerimaan' => '2024-10-06',
                'ID_Barang' => 3,
                'ID_Supplier' => 2,
                'Jumlah' => 15,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
