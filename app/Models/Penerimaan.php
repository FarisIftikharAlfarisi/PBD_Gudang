<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penerimaan extends Model
{
    protected $table = 'penerimaans'; // Nama tabel
    protected $primaryKey = 'ID_Penerimaan'; // Primary key

    // Kolom yang dapat diisi (mass assignment)
    protected $fillable = [
        'No_Faktur',
        'Tanggal_Penerimaan',
        'ID_Barang',
        'ID_Supplier',
        'Jumlah',
    ];

    // Relasi ke model Barang
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'ID_Barang');
    }

    // Relasi ke model Supplier
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'ID_Supplier');
    }
}
