<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gudang extends Model
{
    protected $table = 'gudangs'; // Nama tabel
    protected $primaryKey = 'ID_Gudang'; // Primary key

    // Kolom yang dapat diisi (mass assignment)
    protected $fillable = [
        'Nama_Gudang',
        'Lokasi',
    ];
}
