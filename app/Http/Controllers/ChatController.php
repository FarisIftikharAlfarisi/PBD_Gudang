<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Barang;
use App\Models\Karyawan;
use App\Models\Kategori;
use App\Models\Supplier;
use App\Models\Penerimaan;
use App\Models\Pengeluaran;
use App\Models\Detail_Penerimaan;
use App\Models\Detail_Pengeluaran;
use Illuminate\Http\Request;
use App\Http\Resources\DataWarehouseAPI;

class ChatController extends Controller
{
    /*
    * TUJUAN PENGGUNAAN : Pipeline data
    * membuat fungsi pipeline untuk mengambil data dan mengintegrasikan data dari orders, order_details, barang, pengeluaran  dan penerimaan

    berdasarkan driven yang ada, pipeline disini adalah berfungsi untuk membuat setiap data yang ada di tabel order, order_details, barang, pengeluaran dan penerimaan menjadi suatu data warehouse yang bisa dianalisis oleh LLM nantinya

    setelah data dibuat didalam database, maka nanti bisa diproses oleh LLM melalui JSON yang dikirim ke model dalam folder python_llm_services

    model akan melakukan query dan analisis berdasarkan data yang ada di database, dan engirimkan insight dalam bentuk chat interkatif
    */

    public function normalization_process(){


    }

    public function pipeline()
    {



    }
}
