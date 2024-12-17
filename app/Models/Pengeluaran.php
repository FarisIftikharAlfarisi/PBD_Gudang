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
        'ID_Karyawan',
        'Nama_Penerima',
        'Tujuan',
    ];


    // Relasi ke model Karyawan
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'ID_Karyawan');
    }

    public function details()
    {
        return $this->hasMany(Detail_Pengeluaran::class, 'ID_Pengeluaran', 'ID_Pengeluaran');
    }
}
