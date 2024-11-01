<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategoris'; // Nama tabel
    protected $primaryKey = 'ID_Kategori'; // Primary key

    // Kolom yang dapat diisi (mass assignment)
    protected $fillable = [
        'Nama_Kategori',
    ];
}
