<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\LoyalCustomer;
use App\Models\Penerimaan;
use App\Models\Supplier;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function order(Request $request)
    {
        // Ambil semua pembeli untuk dropdown
        $customers = LoyalCustomer::all();

        // Query dasar untuk transaksi dengan join ke tabel loyal_customer
        $query = Order::select(
            'orders.*',
            DB::raw('loyal_customers.Nama_Pelanggan as Nama_Pelanggan')
        )
        ->leftJoin('loyal_customers', 'orders.ID_Pembeli', '=', 'loyal_customers.id');

        // Filter berdasarkan tanggal mulai
        if ($request->filled('start_date')) {
            $query->whereDate('orders.created_at', '>=', $request->start_date);
        }

        // Filter berdasarkan tanggal akhir
        if ($request->filled('end_date')) {
            $query->whereDate('orders.created_at', '<=', $request->end_date);
        }

        // Filter berdasarkan pembeli
        if ($request->filled('customer_id') && $request->customer_id != '') {
            $query->where('orders.ID_Pembeli', $request->customer_id);
        }

        // Hitung total pendapatan dari hasil filter
        $totalPendapatan = $query->clone()->sum('Uang_Masuk');

        // Pagination: Batasi jumlah data per halaman (misalnya 10 data per halaman)
        $transactions = $query->paginate(10);

        // Kirim data ke view
        return view('view-laporan.report_order', compact('transactions', 'customers', 'totalPendapatan'));
    }
  
    public function penerimaan(Request $request)
    {
        // Ambil semua supplier untuk dropdown
        $suppliers = Supplier::all();

        // Query dasar untuk transaksi dengan eager loading relasi supplier
        $query = Penerimaan::with('supplier');

        // Filter berdasarkan tanggal mulai
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        // Filter berdasarkan tanggal akhir
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // Filter berdasarkan supplier
        if ($request->filled('supplier_id') && $request->supplier_id != '') {
            $query->where('ID_Supplier', $request->supplier_id);
        }

        // Pagination: Batasi jumlah data per halaman (misalnya 10 data per halaman)
        $transactions = $query->paginate(10);

        // Kirim data ke view
        return view('view-laporan.report_penerimaan', compact('transactions', 'suppliers'));
    }

    public function pengeluaran(Request $request)
{
    // Query dasar untuk transaksi
    $query = Pengeluaran::query();

    // Filter berdasarkan tanggal mulai
    if ($request->filled('start_date')) {
        $query->whereDate('created_at', '>=', $request->start_date);
    }

    // Filter berdasarkan tanggal akhir
    if ($request->filled('end_date')) {
        $query->whereDate('created_at', '<=', $request->end_date);
    }

    $totalPendapatan = $query->clone()->sum('Total');

    // Pagination: Batasi jumlah data per halaman (misalnya 10 data per halaman)
    $transactions = $query->paginate(10);

    // Kirim data ke view
    return view('view-laporan.report_pengeluaran', compact('transactions', 'totalPendapatan'));
}
}