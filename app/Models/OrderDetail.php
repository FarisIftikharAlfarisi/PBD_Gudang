<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $table = 'order_details';
    protected $primaryKey = 'id';
    protected $fillable = [
        'Nomor_Nota',
        'ID_Barang',
        'Jumlah',
        'Harga_Jual',
        'Diskon_Per_Items',
        'Harga_Akhir',
        'Subtotal',
    ];

    //relasi ke barang berdasarkan ID_Barang
    public function relasibarang() {
        return $this->belongsTo('App\Models\Barang', 'ID_Barang', 'ID_Barang');
    }

    public function order()
    {
        return $this->belongsTo(OrderDetail::class, 'Nomor_Nota', 'Nomor_Nota');
    }
}
