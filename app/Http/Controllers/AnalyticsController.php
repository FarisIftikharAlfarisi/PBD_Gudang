<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Penerimaan;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function analytics(Request $request)
{
    $data_penerimaan = Penerimaan::with('details.barang')->get();
    $data_order = Order::all();
    $data_pengeluaran = Pengeluaran::with('details.barang')->get();

        // Data untuk Dominasi Metode Pembayaran
        $metode_order = Order::select('Metode_Pembayaran', DB::raw('count(*) as count'))
            ->groupBy('Metode_Pembayaran')
            ->get();
    
        $metode_chart_data = $metode_order->map(function ($item) {
            return [
                'label' => $item->Metode_Pembayaran,
                'count' => $item->count
            ];
        });
    
        // Data untuk Revenue Penjualan
        $revenue_daily = Order::select(DB::raw('SUM(Uang_Masuk) as revenue, DATE(created_at) as date'))
            ->groupBy('date')
            ->orderBy('date')
            ->take(7)
            ->get();
    
        $revenue_monthly = Order::select(DB::raw('SUM(Uang_Masuk) as revenue, MONTH(created_at) as month'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();
    
        $revenue_yearly = Order::select(DB::raw('SUM(Uang_Masuk) as revenue, YEAR(created_at) as year'))
            ->groupBy('year')
            ->orderBy('year')
            ->get();
    
        // Data untuk Barang Terlaris
        $best_selling_items = Order::join('order_details', 'orders.Nomor_Nota', '=', 'order_details.Nomor_Nota')
            ->join('barangs', 'order_details.ID_Barang', '=', 'barangs.ID_Barang')  // Join the barang table
            ->select('order_details.ID_Barang', 'barangs.Nama_Barang', DB::raw('SUM(order_details.Jumlah) as total_sold'))
            ->groupBy('order_details.ID_Barang', 'barangs.Nama_Barang')  // Group by both ID_Barang and Nama_Barang
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();
    
        return view('view-dashboard.index', compact(
            'metode_chart_data', 
            'revenue_daily', 
            'revenue_monthly', 
            'revenue_yearly',
            'data_order',
            'data_penerimaan',
            'data_pengeluaran' ,
            'best_selling_items'
        ));
    

    // // Ambil filter dari request, jika tidak ada gunakan nilai default (misalnya tahun saat ini)
    // $tahun = $request->input('tahun', date('Y'));
    // $bulan = $request->input('bulan', null);
    // $hari = $request->input('hari', null);

    // // Query untuk data penerimaan dengan filter bulan, tahun, dan hari
    // $penerimaanQuery = DB::table('penerimaans')
    //     ->join('barangs', 'penerimaans.ID_Barang', '=', 'barangs.ID_Barang')
    //     ->select(
    //         DB::raw('DATE(Tanggal_Penerimaan) as tanggal'),
    //         DB::raw('SUM(penerimaans.Jumlah * barangs.Harga_Pokok) as total_harga')
    //     )
    //     ->whereYear('Tanggal_Penerimaan', $tahun);

    // if ($bulan) {
    //     $penerimaanQuery->whereMonth('Tanggal_Penerimaan', $bulan);
    // }

    // if ($hari) {
    //     $penerimaanQuery->whereDay('Tanggal_Penerimaan', $hari);
    // }

    // $penerimaanData = $penerimaanQuery
    //     ->groupBy('tanggal')
    //     ->orderBy('tanggal')
    //     ->get();

    // // Query untuk data pengeluaran dengan filter bulan, tahun, dan hari
    // $pengeluaranQuery = DB::table('pengeluarans')
    //     ->join('barangs', 'pengeluarans.ID_Barang', '=', 'barangs.ID_Barang')
    //     ->select(
    //         DB::raw('DATE(Tanggal_Pengeluaran) as tanggal'),
    //         DB::raw('SUM(pengeluarans.Jumlah * (barangs.Harga_Jual - barangs.Harga_Pokok)) as total_keuntungan')
    //     )
    //     ->whereYear('Tanggal_Pengeluaran', $tahun);

    // if ($bulan) {
    //     $pengeluaranQuery->whereMonth('Tanggal_Pengeluaran', $bulan);
    // }

    // if ($hari) {
    //     $pengeluaranQuery->whereDay('Tanggal_Pengeluaran', $hari);
    // }

    // $pengeluaranData = $pengeluaranQuery
    //     ->groupBy('tanggal')
    //     ->orderBy('tanggal')
    //     ->get();

    // // review analisa barang
    // // Data untuk Barang yang Paling Diminati
    // $mostWanted = DB::table('pengeluarans')
    //     ->select('barangs.Nama_Barang', DB::raw('SUM(pengeluarans.Jumlah) as total_pembelian'))
    //     ->join('barangs', 'pengeluarans.ID_Barang', '=', 'barangs.ID_Barang')
    //     ->groupBy('pengeluarans.ID_Barang', 'barangs.Nama_Barang')
    //     ->orderByDesc('total_pembelian')
    //     ->take(10)
    //     ->get();

    // // Data untuk Barang dengan Stok Tertinggi yang Kurang Diminati
    // $leastWanted = DB::table('barangs')
    // ->leftJoin('pengeluarans', 'barangs.ID_Barang', '=', 'pengeluarans.ID_Barang')
    // ->join('inventaris', 'barangs.ID_Barang', '=', 'inventaris.ID_Barang') // Join dengan tabel inventaris
    // ->select('barangs.Nama_Barang', 'inventaris.Jumlah_Barang_Aktual', DB::raw('COALESCE(SUM(pengeluarans.Jumlah), 0) as total_pengeluaran'))
    // ->groupBy('barangs.ID_Barang', 'barangs.Nama_Barang', 'inventaris.Jumlah_Barang_Aktual')
    // ->orderByDesc('inventaris.Jumlah_Barang_Aktual') // Urutkan berdasarkan stok aktual tertinggi
    // ->take(10)
    // ->get();

    // // mengetahui performa karyawan
    // // $pengeluaranDataByEmp = DB::table('pengeluarans')
    // // ->join('karyawans', 'pengeluarans.ID_Karyawan', '=', 'karyawans.ID_Karyawan')
    // // ->select('karyawans.Nama_Karyawan', DB::raw('COUNT(pengeluarans.ID_Pengeluaran) as total_pengeluaran'))
    // // ->groupBy('karyawans.ID_Karyawan', 'karyawans.Nama_Karyawan')
    // // ->orderByDesc('total_pengeluaran')
    // // ->take(10)
    // // ->get();

    // // $penerimaanDataByEmp = DB::table('penerimaans')
    // // ->join('karyawans', 'penerimaans.ID_Karyawan', '=', 'karyawans.ID_Karyawan')
    // // ->select('karyawans.Nama_Karyawan', DB::raw('COUNT(penerimaans.ID_Penerimaan) as total_penerimaan'))
    // // ->groupBy('karyawans.ID_Karyawan', 'karyawans.Nama_Karyawan')
    // // ->orderByDesc('total_penerimaan')
    // // ->take(10)
    // // ->get();

    // return view('view-dashboard.index');
    }

}
