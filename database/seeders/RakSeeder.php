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
                'Kapasitas_Rak' => 50,
                'Status_Rak' => 'Aktif',
                'ID_Gudang' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'Nomor_Rak' => 'R02',
                'Lokasi_Rak' => 'Lantai 1',
                'Kapasitas_Rak' => 40,
                'Status_Rak' => 'Aktif',
                'ID_Gudang' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'Nomor_Rak' => 'R03',
                'Lokasi_Rak' => 'Lantai 2',
                'Kapasitas_Rak' => 60,
                'Status_Rak' => 'Aktif',
                'ID_Gudang' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'Nomor_Rak' => 'R04',
                'Lokasi_Rak' => 'Lantai 2',
                'Kapasitas_Rak' => 30,
                'Status_Rak' => 'Tidak Aktif',
                'ID_Gudang' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'Nomor_Rak' => 'R05',
                'Lokasi_Rak' => 'Lantai 3',
                'Kapasitas_Rak' => 70,
                'Status_Rak' => 'Aktif',
                'ID_Gudang' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'Nomor_Rak' => 'R06',
                'Lokasi_Rak' => 'Lantai 1',
                'Kapasitas_Rak' => 55,
                'Status_Rak' => 'Aktif',
                'ID_Gudang' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'Nomor_Rak' => 'R07',
                'Lokasi_Rak' => 'Lantai 2',
                'Kapasitas_Rak' => 35,
                'Status_Rak' => 'Aktif',
                'ID_Gudang' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'Nomor_Rak' => 'R08',
                'Lokasi_Rak' => 'Lantai 2',
                'Kapasitas_Rak' => 65,
                'Status_Rak' => 'Tidak Aktif',
                'ID_Gudang' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'Nomor_Rak' => 'R09',
                'Lokasi_Rak' => 'Lantai 3',
                'Kapasitas_Rak' => 45,
                'Status_Rak' => 'Aktif',
                'ID_Gudang' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'Nomor_Rak' => 'R10',
                'Lokasi_Rak' => 'Lantai 3',
                'Kapasitas_Rak' => 80,
                'Status_Rak' => 'Aktif',
                'ID_Gudang' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
