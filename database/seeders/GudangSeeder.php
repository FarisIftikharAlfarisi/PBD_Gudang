<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class GudangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('gudangs')->insert([
            [
                'Nama_Gudang' => 'Gudang Utama',
                'Lokasi' => 'Jl. Raya Industri No. 123, Jakarta',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'Nama_Gudang' => 'Gudang Penyimpanan Cadangan',
                'Lokasi' => 'Jl. Pembangunan No. 456, Bandung',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
