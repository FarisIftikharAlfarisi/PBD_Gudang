<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Barang;
use App\Models\Inventaris;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use App\Models\LoyalCustomer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class KasirController extends Controller
{
    public function index(){
        $barang = Barang::all();
        $inventaris = Inventaris::all();
        $pelanggans = LoyalCustomer::all();
        return view("view-kasir.index", compact('barang', 'pelanggans','inventaris'));
    }

    public function storePesanan(Request $request) {
        // Pembuat nomor nota
        $cashier = Auth::guard('karyawan')->user()->Nomor_karyawan;
        $date = date('dmY');
        $time = date('His');
        $count = Order::where('Tanggal_Pembelian', $date)->count();
        $count = $count + 1;
        $count = str_pad($count, 4, '0', STR_PAD_LEFT);

        $nomor_nota = 'STR-'.$date.$time.$cashier.$count;

        // End pembuat nomor nota
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
                $this->prosesPesanan($nomor_nota, $pesanan);
            }
        } else if ($data_push['customer']['type'] == "PelangganBaru") {
            // Step 1: Buat data pelanggan baru di tabel LoyalCustomer
            $loyal_customer = LoyalCustomer::create([
                'Nama_Pelanggan' => $data_push['customer']['nama'],
                'No_Telepon' => $data_push['customer']['telepon'],
                'Tanggal_Berlangganan' => $date,
            ]);

            // Step 2: Buat data order di tabel Order, sertakan ID pelanggan baru
            Order::create([
                'Nomor_Nota' => $nomor_nota,
                'Tanggal_Pembelian' => $date,
                'Total_Pembayaran' => $data_push['totalPembayaran'],
                'ID_Pembeli' => $loyal_customer->id,
            ]);

            // Step 3: Proses data pesanan
            foreach ($data_push['pesanan'] as $pesanan) {
                $this->prosesPesanan($nomor_nota, $pesanan);
            }
        } else if ($data_push['customer']['type'] == "PelangganBiasa") {
            Order::create([
                'Nomor_Nota' => $nomor_nota,
                'Tanggal_Pembelian' => $date,
                'Total_Pembayaran' => $data_push['totalPembayaran'],
                'ID_Pembeli' => null,
            ]);

            foreach ($data_push['pesanan'] as $pesanan) {
                $this->prosesPesanan($nomor_nota, $pesanan);
            }
        }

        // Kirim nomor nota ke session
        session()->put('Nomor_Nota', $nomor_nota);

        // Redirect ke nota print
        return redirect()->route('kasir-nota-page');
    }

    // Fungsi tambahan untuk proses pesanan
    private function prosesPesanan($nomor_nota, $pesanan) {
        $ID_Barang = $pesanan['id'];
        $jumlah = $pesanan['jumlah'];

        // Periksa stok barang di tabel inventaris
        $inventaris = DB::table('inventaris')->where('ID_Barang', $ID_Barang)->first();

        if ($inventaris) {
            // Validasi stok yang tersedia
            if ($inventaris->Jumlah_Barang_Aktual >= $jumlah) {
                DB::table('inventaris')
                    ->where('ID_Barang', $ID_Barang)
                    ->update([
                        'Jumlah_Barang_Aktual' => $inventaris->Jumlah_Barang_Aktual - $jumlah,
                        'updated_at' => now(),
                    ]);
            } else {
                // Jika stok tidak mencukupi, hentikan proses
                return response()->json([
                    'error' => "Stok barang dengan ID {$ID_Barang} tidak mencukupi. Stok tersedia: {$inventaris->Jumlah_Barang_Aktual}",
                ], 400);
            }
        } else {
            // Jika barang tidak ditemukan di inventaris
            return response()->json([
                'error' => "Barang dengan ID {$ID_Barang} tidak ditemukan di tabel inventaris.",
            ], 400);
        }

        // Menentukan nilai diskon
        $diskon = isset($pesanan['diskon']) ? $pesanan['diskon'] : 0;

        // Data untuk detail order
        $data_order_detail = [
            'Nomor_Nota' => $nomor_nota,
            'ID_Barang' => $ID_Barang,
            'Jumlah' => $jumlah,
            'Harga_Jual' => $pesanan['harga'],
            'Diskon_Per_Items' => $diskon,
            'Harga_Akhir' => $pesanan['harga'] - $diskon,
            'Subtotal' => $pesanan['subTotal'],
            'created_at' => now(),
            'updated_at' => now(),
        ];

        // Menyimpan detail order ke database
        OrderDetail::create($data_order_detail);
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

    public function updatePesanan(Request $request, $nomor_nota){

    $order = Order::where('Nomor_Nota', $nomor_nota)->firstOrFail();

    // Debug data yang diterima
    // dd($request->all());

    $request->validate([
        'nomor_nota' => 'required|string',
        'metode_pembayaran' => 'required|string',
        'uang_masuk' => 'required_if:metode_pembayaran,Tunai|numeric',
        'kembalian' => 'nullable|numeric',
    ]);

    //jika metode pembayarannya tunai maka update bagian kembalian dan uang masuk
    if($request->metode_pembayaran == 'Tunai'){

        $order->update([
            'Metode_Pembayaran' => $request->metode_pembayaran,
            'Uang_Masuk' => $request->uang_masuk,
            'Kembalian' => $request->uang_masuk == $order->Total_Pembayaran ? 0 : $request->uang_masuk - $order->Total_Pembayaran
        ]);
    }else if( $request->metode_pembayaran == 'Transfer' || $request->metode_pembayaran == 'QRIS'){
        $order->update([
            'Metode_Pembayaran' => $request->metode_pembayaran,
            'Uang_Masuk' => $order->Total_Pembayaran,
            'Kembalian' => 0
        ]);
    }else{
        return response()->json(['message' => 'Metode pembayaran tidak ditemukan'], 400);
    }

    $order->save();

    return redirect()->route('kasir-index-page')->with('success', 'Pesanan berhasil diperbarui.');
}

    public function riwayat(){
        $riwayat = Order::all();
        $orderDetail = OrderDetail::all();

        return view('view-kasir.riwayat', compact('riwayat', 'orderDetail'));
    }

}

