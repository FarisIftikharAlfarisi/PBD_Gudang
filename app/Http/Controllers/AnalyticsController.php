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
    $metode_order = Order::select('Metode_Pembayaran', DB::raw('count(*) as count'))
                        ->groupBy('Metode_Pembayaran')
                        ->get();
    $data_pengeluaran = Pengeluaran::with('details.barang')->get();

    return view('view-dashboard.index', compact('data_penerimaan', 'data_order', 'metode_order', 'data_pengeluaran'));


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
