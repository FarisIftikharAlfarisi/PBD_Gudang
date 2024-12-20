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

        $this->call([
            SupplierSeeder::class,
            GudangSeeder::class,
            RakSeeder::class,
            KaryawanSeeder::class,
            KategoriSeeder::class,
            BarangSeeder::class,
            PenerimaanSeeder::class,
            PengeluaranSeeder::class,
            DetailPenerimaanSeeder::class,
            DetailPengeluaranSeeder::class,
            InventarisSeeder::class,
            LoyalCustSeeder::class,

            // Tambahkan seeder lainnya di sini
        ]);


    }
}
