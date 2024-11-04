<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

//         supplier
// gudang
// rak
// karyawan
// kategori
// barang
// penerimaan
// inventaris
// pengeluaran
        $this->call([
            SupplierSeeder::class,
            GudangSeeder::class,
            RakSeeder::class,
            KaryawanSeeder::class,
            KategoriSeeder::class,
            BarangSeeder::class,
            PenerimaanSeeder::class,
            InventarisSeeder::class,
            PengeluaranSeeder::class,
        ]);


    }
}
