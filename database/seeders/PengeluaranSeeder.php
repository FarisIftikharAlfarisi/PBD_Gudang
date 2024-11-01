<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PengeluaranSeeder extends Seeder
{
    public function run()
    {
        DB::table('pengeluarans')->insert([
            [
                'No_Faktur' => 'FKT-001-2024',
                'Tanggal_Pengeluaran' => '2024-10-01',
                'ID_Barang' => 8, // Sesuaikan dengan ID_Barang yang ada
                'ID_Karyawan' => 1, // Sesuaikan dengan ID_Karyawan yang ada
                'Jumlah' => 5,
                'Nama_Penerima' => 'Budi Santoso',
                'Tujuan' => 'Pengiriman Jakarta',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'No_Faktur' => 'FKT-002-2024',
                'Tanggal_Pengeluaran' => '2024-10-02',
                'ID_Barang' => 9,
                'ID_Karyawan' => 2,
                'Jumlah' => 10,
                'Nama_Penerima' => 'Siti Aminah',
                'Tujuan' => 'Pengiriman Surabaya',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
