<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Barang;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use App\Models\LoyalCustomer;
use Illuminate\Support\Facades\Auth;

class KasirController extends Controller
{
    public function index(){
        $barang = Barang::all();
        $pelanggans = LoyalCustomer::all();
        return view("view-kasir.index", compact('barang', 'pelanggans'));
    }

    public function storePesanan(Request $request){

        // pembuat nomor nota
        $cashier = Auth::guard('karyawan')->user()->Nomor_karyawan;
        $date = date('dmY');
        $time = date('His');
        $count = Order::where('Tanggal_Pembelian', $date)->count();
        $count = $count + 1;
        $count = str_pad($count, 4, '0', STR_PAD_LEFT);

        $nomor_nota = 'STR-'.$date.$time.$cashier.$count;

        // end pembuat nomor nota
        $data_push = [
            'pesanan' => json_decode($request->input('pesanan'), true),
            'totalPembayaran' => $request->input('totalPembayaran'),
            'customer' => json_decode($request->input('customer'), true),
        ];

       if ($data_push['customer']['type'] == "PelangganTetap") {
        Order::create([
            'Nomor_Nota' => $nomor_nota,
            'Tanggal_Pembelian' => $date,
            'Total_Pembayaran' => $data_push['totalPembayaran'],
            'ID_Pembeli' => $data_push['customer']['id'],
        ]);

        foreach ($data_push['pesanan'] as $pesanan) {
            // Menentukan nilai diskon
            $diskon = isset($pesanan['diskon']) ? $pesanan['diskon'] : 0;

            // Data untuk detail order
            $data_order_detail = [
                'Nomor_Nota' => $nomor_nota,
                'ID_Barang' => $pesanan['id'],
                'Jumlah' => $pesanan['jumlah'],
                'Harga_Jual' => $pesanan['harga'],
                'Diskon_Per_Items' => $diskon,
                'Subtotal' => $pesanan['subTotal'],
            ];

            // Menyimpan detail order ke database
            OrderDetail::create($data_order_detail);
        }
    }else if ($data_push['customer']['type'] == "PelangganBaru") {
        // Step 1: Buat data pelanggan baru di tabel LoyalCustomer
        $loyal_customer = LoyalCustomer::create([
            'Nama_Pelanggan' => $data_push['customer']['nama'],
            'No_Telepon' => $data_push['customer']['telepon'],
            'Tanggal_Berlangganan' => $date
        ]);

        // Step 2: Buat data order di tabel Order, sertakan ID pelanggan baru
        Order::create([
            'Nomor_Nota' => $nomor_nota,
            'Tanggal_Pembelian' => $date,
            'Total_Pembayaran' => $data_push['totalPembayaran'],
            'ID_Pembeli' => $loyal_customer->id,
        ]);

        // Step 3: Proses data pesanan dan simpan ke tabel OrderDetail
        foreach ($data_push['pesanan'] as $pesanan) {
            // Menentukan nilai diskon
            $diskon = isset($pesanan['diskon']) ? $pesanan['diskon'] : 0;

            // Data untuk detail order
            $data_order_detail = [
                'Nomor_Nota' => $nomor_nota,
                'ID_Barang' => $pesanan['id'],
                'Jumlah' => $pesanan['jumlah'],
                'Harga_Jual' => $pesanan['harga'],
                'Diskon_Per_Items' => $diskon,
                'Subtotal' => $pesanan['subTotal'],
            ];

            // Menyimpan detail order ke database
            OrderDetail::create($data_order_detail);
        }
    }else if($data_push['customer']['type'] == "PelangganBiasa"){
        Order::create([
            'Nomor_Nota' => $nomor_nota,
            'Tanggal_Pembelian' => $date,
            'Total_Pembayaran' => $data_push['totalPembayaran'],
            'ID_Pembeli' => null,
        ]);

        foreach ($data_push['pesanan'] as $pesanan) {
            // Menentukan nilai diskon
            $diskon = isset($pesanan['diskon']) ? $pesanan['diskon'] : 0;

            // Data untuk detail order
            $data_order_detail = [
                'Nomor_Nota' => $nomor_nota,
                'ID_Barang' => $pesanan['id'],
                'Jumlah' => $pesanan['jumlah'],
                'Harga_Jual' => $pesanan['harga'],
                'Diskon_Per_Items' => $diskon,
                'Subtotal' => $pesanan['subTotal'],
            ];

            // Menyimpan detail order ke database
            OrderDetail::create($data_order_detail);
        }
    }

    //kirim nomor nota ke session
    session()->put('Nomor_Nota', $nomor_nota);

    //redirect ke nota print
    return redirect()->route('kasir-nota-page');
    }

    public function daftar_customer(){
        $loyal_customer = LoyalCustomer::all();
        return response()->json($loyal_customer);
    }


    public function printNota(){
        $nomor_nota = session()->get('Nomor_Nota');
        $order = Order::where('Nomor_Nota', $nomor_nota)->first();
        $orderDetail = OrderDetail::where('Nomor_Nota', $nomor_nota)->get();
        return view('view-kasir.nota-print', compact('order', 'orderDetail'));
    }


}

