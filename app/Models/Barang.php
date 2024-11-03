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

    //relasi ke model penerimaan
    public function penerimaan(){
        return $this->hasMany(Penerimaan::class, 'ID_Barang');
    }

    //relasi ke model pengeluaran
    public function pengeluaran(){
        return $this->hasMany(Pengeluaran::class, 'ID_Barang');
    }

    //relasi ke model inventaris
    public function inventaris(){
        return $this->hasOne(Inventaris::class, 'ID_Barang');
    }
}
