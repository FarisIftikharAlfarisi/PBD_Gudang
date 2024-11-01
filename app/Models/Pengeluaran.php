<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    protected $table = 'pengeluarans'; // Nama tabel
    protected $primaryKey = 'ID_Pengeluaran'; // Primary key

    // Kolom yang dapat diisi (mass assignment)
    protected $fillable = [
        'No_Faktur',
        'Tanggal_Pengeluaran',
        'ID_Barang',
        'ID_Karyawan',
        'Jumlah',
        'Nama_Penerima',
        'Tujuan',
    ];

    // Relasi ke model Barang
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'ID_Barang');
    }

    // Relasi ke model Karyawan
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'ID_Karyawan');
    }
}
