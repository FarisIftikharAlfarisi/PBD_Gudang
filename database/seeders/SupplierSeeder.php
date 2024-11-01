<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
    public function run()
    {
        DB::table('suppliers')->insert([
            [
                'Nama_Supplier' => 'PT. Sinar Jaya Abadi',
                'Alamat' => 'Jl. Merdeka No. 123, Jakarta',
                'Nomor_Telepon' => '0215551234',
                'Email' => 'info@sinarjaya.com',
                'Spesialisasi' => 'Suku cadang mesin dan pelumas',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'Nama_Supplier' => 'CV. Mega Motor',
                'Alamat' => 'Jl. Raya Surabaya No. 45, Surabaya',
                'Nomor_Telepon' => '0318875432',
                'Email' => 'contact@megamotor.co.id',
                'Spesialisasi' => 'Aksesori motor dan ban',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'Nama_Supplier' => 'Toko Sparepart Bandung',
                'Alamat' => 'Jl. Asia Afrika No. 7, Bandung',
                'Nomor_Telepon' => '0225439876',
                'Email' => 'sales@sparepartbandung.com',
                'Spesialisasi' => 'Suku cadang motor sport',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'Nama_Supplier' => 'PT. Cahaya Abadi',
                'Alamat' => 'Jl. Diponegoro No. 11, Medan',
                'Nomor_Telepon' => '0617788899',
                'Email' => 'info@cahayaabadi.com',
                'Spesialisasi' => 'Shockbreaker dan suspensi',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'Nama_Supplier' => 'UD. Sparepart Makassar',
                'Alamat' => 'Jl. Pettarani No. 25, Makassar',
                'Nomor_Telepon' => '0411443221',
                'Email' => 'support@sparepartmakassar.com',
                'Spesialisasi' => 'Velg dan gear motor',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
