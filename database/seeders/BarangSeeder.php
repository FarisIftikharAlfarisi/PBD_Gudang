<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    public function run()
    {
        DB::table('barangs')->insert([
            [
                'ID_Kategori' => 1,
                'ID_Rak' => 1,
                'Nama_Barang' => 'Oli Mesin',
                'Deskripsi' => 'Oli mesin berkualitas untuk kendaraan bermotor',
                'Satuan' => 'Liter',
                'Harga_Pokok' => 50000.00,
                'Harga_Jual' => 75000.00,
                'Kode_Part' => 'OLM001',
                'Merek' => 'Pertamina',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'ID_Kategori' => 1,
                'ID_Rak' => 2,
                'Nama_Barang' => 'Filter Udara',
                'Deskripsi' => 'Filter udara untuk menjaga kebersihan mesin',
                'Satuan' => 'Pcs',
                'Harga_Pokok' => 35000.00,
                'Harga_Jual' => 50000.00,
                'Kode_Part' => 'FLU002',
                'Merek' => 'Denso',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'ID_Kategori' => 2,
                'ID_Rak' => 3,
                'Nama_Barang' => 'Kampas Rem',
                'Deskripsi' => 'Kampas rem depan untuk motor',
                'Satuan' => 'Set',
                'Harga_Pokok' => 80000.00,
                'Harga_Jual' => 120000.00,
                'Kode_Part' => 'KPR003',
                'Merek' => 'Nissin',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'ID_Kategori' => 2,
                'ID_Rak' => 4,
                'Nama_Barang' => 'Aki Motor',
                'Deskripsi' => 'Aki motor tipe MF',
                'Satuan' => 'Pcs',
                'Harga_Pokok' => 150000.00,
                'Harga_Jual' => 200000.00,
                'Kode_Part' => 'AKM004',
                'Merek' => 'GS Astra',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'ID_Kategori' => 3,
                'ID_Rak' => 5,
                'Nama_Barang' => 'Busi Motor',
                'Deskripsi' => 'Busi motor iridium',
                'Satuan' => 'Pcs',
                'Harga_Pokok' => 25000.00,
                'Harga_Jual' => 40000.00,
                'Kode_Part' => 'BSM005',
                'Merek' => 'NGK',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'ID_Kategori' => 3,
                'ID_Rak' => 6,
                'Nama_Barang' => 'Ban Depan',
                'Deskripsi' => 'Ban depan motor ukuran 80/90-14',
                'Satuan' => 'Pcs',
                'Harga_Pokok' => 220000.00,
                'Harga_Jual' => 270000.00,
                'Kode_Part' => 'BDM006',
                'Merek' => 'IRC',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'ID_Kategori' => 4,
                'ID_Rak' => 7,
                'Nama_Barang' => 'Ban Belakang',
                'Deskripsi' => 'Ban belakang motor ukuran 90/90-14',
                'Satuan' => 'Pcs',
                'Harga_Pokok' => 250000.00,
                'Harga_Jual' => 300000.00,
                'Kode_Part' => 'BBM007',
                'Merek' => 'Michelin',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'ID_Kategori' => 4,
                'ID_Rak' => 8,
                'Nama_Barang' => 'Kabel Kopling',
                'Deskripsi' => 'Kabel kopling untuk motor sport',
                'Satuan' => 'Pcs',
                'Harga_Pokok' => 45000.00,
                'Harga_Jual' => 60000.00,
                'Kode_Part' => 'KKM008',
                'Merek' => 'TDR',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'ID_Kategori' => 5,
                'ID_Rak' => 9,
                'Nama_Barang' => 'Shockbreaker Depan',
                'Deskripsi' => 'Shockbreaker depan motor matic',
                'Satuan' => 'Set',
                'Harga_Pokok' => 400000.00,
                'Harga_Jual' => 550000.00,
                'Kode_Part' => 'SBD009',
                'Merek' => 'Showa',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'ID_Kategori' => 5,
                'ID_Rak' => 10,
                'Nama_Barang' => 'Shockbreaker Belakang',
                'Deskripsi' => 'Shockbreaker belakang motor sport',
                'Satuan' => 'Set',
                'Harga_Pokok' => 450000.00,
                'Harga_Jual' => 600000.00,
                'Kode_Part' => 'SBB010',
                'Merek' => 'YSS',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'ID_Kategori' => 6,
                'ID_Rak' => 1,
                'Nama_Barang' => 'Lampu LED',
                'Deskripsi' => 'Lampu LED untuk penerangan depan motor',
                'Satuan' => 'Pcs',
                'Harga_Pokok' => 15000.00,
                'Harga_Jual' => 25000.00,
                'Kode_Part' => 'LLD011',
                'Merek' => 'Osram',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'ID_Kategori' => 6,
                'ID_Rak' => 2,
                'Nama_Barang' => 'Spion Motor',
                'Deskripsi' => 'Spion motor matic kiri-kanan',
                'Satuan' => 'Set',
                'Harga_Pokok' => 70000.00,
                'Harga_Jual' => 90000.00,
                'Kode_Part' => 'SPM012',
                'Merek' => 'Ferrox',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'ID_Kategori' => 7,
                'ID_Rak' => 3,
                'Nama_Barang' => 'Velg Motor',
                'Deskripsi' => 'Velg motor jari-jari ukuran 17 inci',
                'Satuan' => 'Set',
                'Harga_Pokok' => 550000.00,
                'Harga_Jual' => 700000.00,
                'Kode_Part' => 'VMJ013',
                'Merek' => 'TK Racing',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'ID_Kategori' => 7,
                'ID_Rak' => 4,
                'Nama_Barang' => 'Gear Set',
                'Deskripsi' => 'Gear set motor sport',
                'Satuan' => 'Set',
                'Harga_Pokok' => 120000.00,
                'Harga_Jual' => 160000.00,
                'Kode_Part' => 'GST014',
                'Merek' => 'SSS',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'ID_Kategori' => 8,
                'ID_Rak' => 5,
                'Nama_Barang' => 'Stang Motor',
                'Deskripsi' => 'Stang motor sport alumunium',
                'Satuan' => 'Pcs',
                'Harga_Pokok' => 100000.00,
                'Harga_Jual' => 140000.00,
                'Kode_Part' => 'STM015',
                'Merek' => 'Ride It',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
