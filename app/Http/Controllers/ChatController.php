<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Barang;
use App\Models\Karyawan;
use App\Models\Kategori;
use App\Models\Supplier;
use App\Models\Penerimaan;
use App\Models\Pengeluaran;
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

    public function pipeline()
    {
        // Ambil data pesanan
        $data_order = Order::with('order_details')->get();

        // Susun data JSON
        $json_data = [];
        foreach ($data_order as $order) {
            $detail_pembelian = [];
            foreach ($order->order_details as $order_details) {
                $barang = Barang::find($order_details->ID_Barang);
                $kategori = Kategori::find($barang->Kategori_ID);

                $detail_pembelian[] = [
                    'barang' => $barang->Nama_Barang ?? 'Barang tidak ditemukan',
                    'kategori' => $kategori->Nama_Kategori ?? 'Kategori tidak ditemukan',
                    'jumlah' => $order_details->Jumlah,
                    'diskon_per_item' => $order_details->Diskon_Per_Items,
                    'harga' => $order_details->Harga_Akhir,
                    'subtotal' => $order_details->Subtotal,
                ];
            }

            $json_data[] = [
                'nomor_nota' => $order->Nomor_Nota,
                'total_pembayaran' => $order->Total_Pembayaran,
                'tanggal_transaksi' => $order->Tanggal_Pembelian,
                'metode_pembayaran' => $order->Metode_Pembayaran,
                'karyawan' => $order->karyawan->Nama_Karyawan,
                'detail_pembelian' => $detail_pembelian,
            ];
        }

        $to_api_send = [
            'status' => 'success',
            'message' => 'Data pipeline berhasil diambil',
            'data' => $json_data,
        ];

      return response()->json($to_api_send);

    }
}
