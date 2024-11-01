<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table = 'suppliers';
    protected $primaryKey = 'ID_Supplier';

    protected $fillable = [
        'Nama_Supplier',
        'Alamat',
        'Nomor_Telepon',
        'Email',
        'Spesialisasi',
    ];
}
