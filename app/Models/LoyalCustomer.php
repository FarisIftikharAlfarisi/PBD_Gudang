<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoyalCustomer extends Model
{
    protected $table='loyal_customers';
    protected $primaryKey = 'id';

    protected $fillable = [
        'Nama_Pelanggan',
        'No_Telepon',
        'Tanggal_Berlangganan',
    ];

    public function orderRelation(){
        return $this->hasMany(Order::class,'ID_Pembeli');
    }
}
