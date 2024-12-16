<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $primary_key = 'id';

    protected $fillable = [
        'Nomor_Nota',
        'Tanggal_Pembelian',
        'Metode_Pembayaran',
        'Uang_Masuk',
        'Kembalian',
        'Total_Pembayaran',
        'ID_Pembeli',
    ];

    public function customreRelation(){
        return $this->belongsTo(LoyalCustomer::class);
    }
}
