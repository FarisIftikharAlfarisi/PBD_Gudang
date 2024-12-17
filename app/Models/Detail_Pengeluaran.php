<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail_Pengeluaran extends Model
{
    use HasFactory;

    protected $table = 'detail_pengeluarans';
    protected $fillable = ['ID_Pengeluaran', 'ID_Barang', 'qty'];

    public function penerimaan()
    {
        return $this->belongsTo(Penerimaan::class, 'ID_Pengeluaran','ID_Pengeluaran');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'ID_Barang', 'ID_Barang');
    }

}

?>
