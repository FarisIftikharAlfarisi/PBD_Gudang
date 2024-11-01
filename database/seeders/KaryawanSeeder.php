<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class KaryawanSeeder extends Seeder
{
    public function run()
    {
        DB::table('karyawans')->insert([
            [
                'Nomor_karyawan' => 'KRY001',
                'email' => 'karyawan1@example.com',
                'password' => Hash::make('password1'),
                'Nama_Karyawan' => 'Karyawan Satu',
                'Alamat' => 'Jl. Mawar No. 1',
                'Nomor_Telepon' => '081234567891',
                'Jabatan' => 'Owner',
            ],
            [
                'Nomor_karyawan' => 'KRY002',
                'email' => 'karyawan2@example.com',
                'password' => Hash::make('password2'),
                'Nama_Karyawan' => 'Karyawan Dua',
                'Alamat' => 'Jl. Melati No. 2',
                'Nomor_Telepon' => '081234567892',
                'Jabatan' => 'Owner',
            ],
            [
                'Nomor_karyawan' => 'KRY003',
                'email' => 'karyawan3@example.com',
                'password' => Hash::make('password3'),
                'Nama_Karyawan' => 'Karyawan Tiga',
                'Alamat' => 'Jl. Anggrek No. 3',
                'Nomor_Telepon' => '081234567893',
                'Jabatan' => 'Staff',
            ],
            [
                'Nomor_karyawan' => 'KRY004',
                'email' => 'karyawan4@example.com',
                'password' => Hash::make('password4'),
                'Nama_Karyawan' => 'Karyawan Empat',
                'Alamat' => 'Jl. Kenanga No. 4',
                'Nomor_Telepon' => '081234567894',
                'Jabatan' => 'Staff',
            ],
            [
                'Nomor_karyawan' => 'KRY005',
                'email' => 'karyawan5@example.com',
                'password' => Hash::make('password5'),
                'Nama_Karyawan' => 'Karyawan Lima',
                'Alamat' => 'Jl. Flamboyan No. 5',
                'Nomor_Telepon' => '081234567895',
                'Jabatan' => 'Staff',
            ],
            [
                'Nomor_karyawan' => 'KRY006',
                'email' => 'karyawan6@example.com',
                'password' => Hash::make('password6'),
                'Nama_Karyawan' => 'Karyawan Enam',
                'Alamat' => 'Jl. Sakura No. 6',
                'Nomor_Telepon' => '081234567896',
                'Jabatan' => 'Staff',
            ],
            [
                'Nomor_karyawan' => 'KRY007',
                'email' => 'karyawan7@example.com',
                'password' => Hash::make('password7'),
                'Nama_Karyawan' => 'Karyawan Tujuh',
                'Alamat' => 'Jl. Dahlia No. 7',
                'Nomor_Telepon' => '081234567897',
                'Jabatan' => 'Staff',
            ],
            [
                'Nomor_karyawan' => 'KRY008',
                'email' => 'karyawan8@example.com',
                'password' => Hash::make('password8'),
                'Nama_Karyawan' => 'Karyawan Delapan',
                'Alamat' => 'Jl. Kamboja No. 8',
                'Nomor_Telepon' => '081234567898',
                'Jabatan' => 'Staff',
            ],
            [
                'Nomor_karyawan' => 'KRY009',
                'email' => 'karyawan9@example.com',
                'password' => Hash::make('password9'),
                'Nama_Karyawan' => 'Karyawan Sembilan',
                'Alamat' => 'Jl. Cempaka No. 9',
                'Nomor_Telepon' => '081234567899',
                'Jabatan' => 'Supervisor',
            ],
            [
                'Nomor_karyawan' => 'KRY010',
                'email' => 'karyawan10@example.com',
                'password' => Hash::make('password10'),
                'Nama_Karyawan' => 'Karyawan Sepuluh',
                'Alamat' => 'Jl. Bougenville No. 10',
                'Nomor_Telepon' => '081234567810',
                'Jabatan' => 'Manager',
            ],
        ]);
    }
}
