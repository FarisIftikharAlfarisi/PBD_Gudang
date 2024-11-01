<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    public function run()
    {
        DB::table('kategoris')->insert([
            [
                'Nama_Kategori' => 'Pelumas & Cairan',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'Nama_Kategori' => 'Suku Cadang Mesin',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'Nama_Kategori' => 'Ban & Velg',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'Nama_Kategori' => 'Kabel & Kopling',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'Nama_Kategori' => 'Suspensi & Shockbreaker',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'Nama_Kategori' => 'Elektrikal & Lampu',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'Nama_Kategori' => 'Velg & Gear',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'Nama_Kategori' => 'Aksesori Motor',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
