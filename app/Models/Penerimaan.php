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
        'ID_Supplier',
        'ID_Karyawan',
    ];


    // Relasi ke model Supplier
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'ID_Supplier', 'ID_Supplier');
    }

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'ID_Karyawan','ID_Karyawan');
    }

    public function details()
    {
        return $this->hasMany(Detail_Penerimaan::class, 'ID_Penerimaan', 'ID_Penerimaan');
    }


}
