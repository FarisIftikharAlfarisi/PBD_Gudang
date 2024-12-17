<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventaris extends Model
{
    protected $fillable = [
        'ID_Barang',
        'Jumlah_Barang_Aktual'
    ];

    public function barang() {
        return $this->belongsTo(Barang::class,'ID_Barang');
    }

}
