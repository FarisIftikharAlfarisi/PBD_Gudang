<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail_Penerimaan extends Model
{
    use HasFactory;

    protected $table = 'detail_penerimaans';
    protected $fillable = ['ID_Penerimaan', 'ID_Barang', 'qty'];

    public function penerimaan()
    {
        return $this->belongsTo(Penerimaan::class, 'ID_Penerimaan','ID_Penerimaan');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'ID_Barang', 'ID_Barang');
    }

}

?>
