<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RakSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('raks')->insert([
            [
                'Nomor_Rak' => 'R01',
                'Lokasi_Rak' => 'Lantai 1',
                'ID_Gudang' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'Nomor_Rak' => 'R02',
                'Lokasi_Rak' => 'Lantai 1',
                'ID_Gudang' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'Nomor_Rak' => 'R03',
                'Lokasi_Rak' => 'Lantai 2',
                'ID_Gudang' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'Nomor_Rak' => 'R04',
                'Lokasi_Rak' => 'Lantai 2',
                'ID_Gudang' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'Nomor_Rak' => 'R05',
                'Lokasi_Rak' => 'Lantai 3',
                'ID_Gudang' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'Nomor_Rak' => 'R06',
                'Lokasi_Rak' => 'Lantai 1',
                'ID_Gudang' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'Nomor_Rak' => 'R07',
                'Lokasi_Rak' => 'Lantai 2',
                'ID_Gudang' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'Nomor_Rak' => 'R08',
                'Lokasi_Rak' => 'Lantai 2',
                'ID_Gudang' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'Nomor_Rak' => 'R09',
                'Lokasi_Rak' => 'Lantai 3',
                'ID_Gudang' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'Nomor_Rak' => 'R10',
                'Lokasi_Rak' => 'Lantai 3',
                'ID_Gudang' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
