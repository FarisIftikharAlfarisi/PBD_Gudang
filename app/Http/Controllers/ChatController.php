<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Barang;
use GuzzleHttp\Client;
use App\Models\Karyawan;
use App\Models\Kategori;
use App\Models\Supplier;
use App\Models\Penerimaan;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use App\Models\Detail_Penerimaan;
use App\Models\Detail_Pengeluaran;
use Illuminate\Support\Facades\Http;
// use LucianoTonet\GroqLaravel\Facades\Groq;
use LucianoTonet\GroqPHP\Groq;


/*
* TUJUAN PENGGUNAAN : Pipeline data
* membuat fungsi pipeline untuk mengambil data dan mengintegrasikan data dari orders, order_details, barang, pengeluaran  dan penerimaan

berdasarkan driven yang ada, pipeline disini adalah berfungsi untuk membuat setiap data yang ada di tabel order, order_details, barang, pengeluaran dan penerimaan menjadi suatu data warehouse yang bisa dianalisis oleh LLM nantinya

setelah data dibuat didalam database, maka nanti bisa diproses oleh LLM melalui JSON yang dikirim ke model dalam folder python_llm_services

model akan melakukan query dan analisis berdasarkan data yang ada di database, dan engirimkan insight dalam bentuk chat interkatif
*/
class ChatController extends Controller
{


    public function pipeline()
    {
        $orders = Order::join('order_details', 'orders.Nomor_Nota', '=', 'order_details.Nomor_Nota')
            ->join('barangs', 'order_details.ID_Barang', '=', 'barangs.ID_Barang')
            ->select(
                'orders.Nomor_Nota AS nomor_nota',
                'orders.ID_Pembeli AS pembeli',
                'barangs.Nama_Barang AS nama_barang',
                'order_details.Jumlah as jumlah',
                'order_details.Harga_Jual as harga_jual',
                'order_details.Diskon_Per_Items as diskon',
                'order_details.Harga_Akhir as harga_akhir',
                'order_details.Subtotal as subtotal',
                'orders.Total_Pembayaran as total_pembayaran',
                'orders.Metode_Pembayaran as metode_pembayaran'
            )
            ->get();

        $json_data = [
            'status' => 200,
            'message' => 'Pipeline data',
            'data' => $orders
        ];

        return response()->json($json_data);
    }

    public function sendMessage(Request $request){

        $prompt = $request->input('message');

        $groq = new Groq(config('app.LLM_API_KEY'));

        try {
            $chatCompletions = $groq->chat()->completions()->create([
               'model' => config('app.LLM_MODEL'),
               'messages' => [
                    ['role' => 'system', 'content' => 'You are a helpful assistant.'],
                    ['role' => 'user', 'content' => $prompt],
                ],
            ]);

            $responseContent = $chatCompletions['choices'][0]['message']['content'];
        } catch (\Exception $e) {
            $responseContent = 'Error: '. $e->getMessage();
        }

        return response()->json(['response' => $responseContent]);
    }

    public function chatpanel(){
        return view('view-chat.chat');
    }
}
