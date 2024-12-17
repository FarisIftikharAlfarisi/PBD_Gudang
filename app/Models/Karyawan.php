<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class Karyawan extends Authenticatable
{
    use Notifiable;

    protected $table = 'karyawans';
    protected $primaryKey = 'ID_Karyawan';

    // Kolom yang diizinkan untuk mass assignment
    protected $fillable = [
        'ID_Karyawan',
        'Nomor_karyawan',
        'email',
        'password',
        'Nama_Karyawan',
        'Alamat',
        'Nomor_Telepon',
        'Jabatan',
    ];

    // Kolom yang harus disembunyikan saat serialisasi, seperti password
    protected $hidden = [
        'password'
    ];

    // Buat hashing password
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }
}
