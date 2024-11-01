<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rak extends Model
{
    protected $table = 'raks'; // Nama tabel
    protected $primaryKey = 'ID_Rak'; // Primary key

    // Kolom yang dapat diisi (mass assignment)
    protected $fillable = [
        'Nomor_Rak',
        'Lokasi_Rak',
        'Kapasitas_Rak',
        'Status_Rak',
        'ID_Gudang',
    ];

    // Relasi ke model Gudang
    public function gudang()
    {
        return $this->belongsTo(Gudang::class, 'ID_Gudang');
    }

    // Scope untuk filter rak yang available
    public function scopeAvailable($query)
    {
        return $query->where('Status_Rak', 'available');
    }

    // Scope untuk filter rak yang maintenance
    public function scopeMaintenance($query)
    {
        return $query->where('Status_Rak', 'maintenance');
    }
}
