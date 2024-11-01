<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'barangs'; // Nama tabel
    protected $primaryKey = 'ID_Barang'; // Primary key

    // Kolom yang dapat diisi (mass assignment)
    protected $fillable = [
        'ID_Kategori',
        'ID_Rak',
        'Nama_Barang',
        'Deskripsi',
        'Satuan',
        'Harga_Pokok',
        'Harga_Jual',
        'Kode_Part',
        'Merek',
    ];

    // Relasi ke model Kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'ID_Kategori');
    }

    // Relasi ke model Rak
    public function rak()
    {
        return $this->belongsTo(Rak::class, 'ID_Rak');
    }
}
