<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventaris extends Model
{
    protected $fillable = [
        'ID_Barang',
        'ID_Karyawan',
        'Jumlah_Barang_Aktual'
    ];

    public function barang() {
        return $this->belongsTo(Barang::class,'ID_Barang');
    }

    public function karyawan() {
        return $this->belongsTo(Karyawan::class,'ID_Karyawan');
    }
}
