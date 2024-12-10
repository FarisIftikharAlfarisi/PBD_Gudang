<?php

namespace Database\Seeders;

use App\Models\LoyalCustomer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LoyalCustSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LoyalCustomer::create([
            'Nama_Pelanggan'=> 'John Doe',
            'No_Telepon' => '1234567890',
            'Tanggal_Berlangganan' => now(),
        ]);
        LoyalCustomer::create([
            'Nama_Pelanggan'=> 'Ipang Budi',
            'No_Telepon' => '0987654321',
            'Tanggal_Berlangganan' => now(),
        ]);
    }
}
