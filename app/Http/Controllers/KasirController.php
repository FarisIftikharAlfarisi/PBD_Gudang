<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\LoyalCustomer;
use Illuminate\Http\Request;

class KasirController extends Controller
{
    public function index(){
        $barang = Barang::all();
        $loyal_customer = LoyalCustomer::all();
        return view("view-kasir.index", compact('barang', 'loyal_customer'));
    }

    public function storePesanan(Request $request){
        $pesanan = json_decode($request->input('pesanan'), true);
        $totalPembayaran = $request->input('totalPembayaran');
        $dataPelanggan = json_decode($request->input('dataPelanggan'), true);

        dd($pesanan,$dataPelanggan,$totalPembayaran);

        //tugas padli :
        // ambil semua data dari view
        // dump die dulu biar ketahuan data nya pada masuk atau nggak
        // 3 yang harus di cek : kondisi kalo pelanggan adalah pelanggan tetap
        //                       kondisi kalo pelanggan adalah pelanggan baru
        //                       kondisi kalo pelanggan adalah pelanggan biasa yang tiba tiba spawn
        // 3 kondisi di atas harus di cek datanya masuk semua nggak
        // nanti validasi value valuenya buat di sesuaikan sama field field di tabel loyal customers, orders, sama orders detail

        //PROSES PENYIMPANAN DATA :
        // 1. simpan data loyal customer (soalnya ada relasi dari loyal customer ke orders)
        // 2. simpan data orders
        // 3. simpan data orders detail

        //kalau berhasil disimpan, langsung alihkan kasir ke tampilan nota print.php, redirect nya dibawah
        //return redirect()->route('nota-print-page')->with(compact('pesanan', 'totalPembayaran', 'dataPelanggan'));
        //kalau gagal disimpan tampilkan pesan error
    }

    //test view print nota
    public function printNota() {
        // Data dummy untuk pembeli
        $pembeli = (object) [
            'nama' => 'John Doe',
        ];

        // Data dummy untuk kasir
        $kasir = (object) [
            'nama' => 'Jane Smith',
        ];

        // Data dummy untuk barang yang dibeli
        $barangDetails = collect([
            (object) [
                'nama_barang' => 'Barang A',
                'harga' => 100000,
                'pivot' => (object) ['jumlah' => 2],
            ],
            (object) [
                'nama_barang' => 'Barang B',
                'harga' => 200000,
                'pivot' => (object) ['jumlah' => 1],
            ],
            (object) [
                'nama_barang' => 'Barang C',
                'harga' => 50000,
                'pivot' => (object) ['jumlah' => 5],
            ],
        ]);

        // Total
        $total = $barangDetails->reduce(function ($carry, $barang) {
            return $carry + ($barang->harga * $barang->pivot->jumlah);
        }, 0);

        // Mengirim data ke view
        return view('view-kasir.nota-print', compact('pembeli', 'kasir', 'barangDetails', 'total'));
    }


}

