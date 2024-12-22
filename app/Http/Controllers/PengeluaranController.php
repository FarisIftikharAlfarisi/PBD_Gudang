<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Karyawan;
use App\Models\Inventaris;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class PengeluaranController extends Controller
{
    // Menampilkan daftar pengeluaran
    public function index()
    {
        $pengeluarans = Pengeluaran::with(['karyawan','details.barang'])
            ->orderBy('id_pengeluaran', 'desc')
            ->get();
        return view('view-pengeluaran.index', compact('pengeluarans'));
    }

    // Menampilkan form untuk membuat pengeluaran baru
    public function create()
    {
        // Pembuat nomor faktur
        $penanggung_jawab = Auth::guard('karyawan')->user()->Nomor_karyawan;
        $date = date('Y-m-d'); // Format tanggal standar (YYYY-MM-DD) untuk filter
        $formattedDate = date('dmY'); // Format tanggal untuk nomor faktur

        // Hitung jumlah pengeluaran pada tanggal tersebut
        $count = Pengeluaran::whereDate('created_at', $date)->count();
        $count = $count + 1; // Tambahkan 1 untuk faktur berikutnya
        $count = str_pad($count, 4, '0', STR_PAD_LEFT); // Tambahkan padding jika perlu

        // Buat nomor faktur
        $nomor_faktur = 'FK/' . $formattedDate . '/JDM/SV/' . $penanggung_jawab . '/' . $count;



        $barangs = DB::table('inventaris')
            ->join('barangs', 'inventaris.ID_Barang', '=', 'barangs.ID_Barang')
            ->select('barangs.*' ,'inventaris.Jumlah_Barang_Aktual')
            ->where('inventaris.Jumlah_Barang_Aktual', '>', 0)->get();
        $karyawans = Karyawan::all(); // Daftar karyawan untuk dropdown
        return view('view-pengeluaran.create', compact('barangs', 'karyawans','nomor_faktur'));
    }

    // Menyimpan pengeluaran baru
    public function store(Request $request)
{
    // Validasi data input
    $request->validate([
        'No_Faktur' => 'required|string|unique:pengeluarans,no_faktur',
        'Tanggal_Pengeluaran' => 'required|date',
        'ID_Barang.*' => 'required|exists:barangs,ID_Barang',
        'Jumlah.*' => 'required|numeric', // Jika jumlah barang diperlukan
    ]);

    // Cek apakah ID_Barang ada di request dan merupakan array
    if (!isset($request->ID_Barang) || !is_array($request->ID_Barang) || count($request->ID_Barang) === 0) {
        return redirect()->back()->with('error', 'Data barang tidak ditemukan.');
    }

    $karyawan = Auth::guard('karyawan')->user(); // Menggunakan guard karyawan
    $karyawan_id = $karyawan->ID_Karyawan;

    // Simpan data utama ke tabel `pengeluarans`
    $pengeluaranId = DB::table('pengeluarans')->insertGetId([
        'No_Faktur' => $request->No_Faktur,
        'Tanggal_Pengeluaran' => $request->Tanggal_Pengeluaran,
        'ID_Karyawan' => $karyawan_id,
        'Nama_Penerima' => $request->Nama_Penerima,
        'Tujuan' => $request->Tujuan,
        'Total' => $request->grand_total,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    // Simpan detail pengeluaran langsung ke tabel `detail_pengeluarans`
    $details = [];
    foreach ($request->ID_Barang as $index => $ID_Barang) {
        $details[] = [
            'ID_Pengeluaran' => $pengeluaranId, // ID dari pengeluaran yang baru dibuat
            'ID_Barang' => $ID_Barang,
            'qty' => $request->Jumlah[$index], // Menambahkan qty (Jumlah)
            'Harga_Jual' => $request->Harga[$index],
            'Diskon' => $request->Diskon[$index],
            'Total' => $request->Subtotal[$index],
            'created_at' => now(),
            'updated_at' => now(),
        ];

        // Update atau tambah jumlah barang di tabel `inventaris`
        $this->updateInventaris($ID_Barang, $request->Jumlah[$index]);
    }

    // Batch insert ke tabel `detail_pengeluarans`
    DB::table('detail_pengeluarans')->insert($details);

    // Redirect ke halaman index dengan pesan sukses
    return redirect()->route('pengeluaran-index-page')->with('success', 'Pengeluaran berhasil disimpan.');
}



/**
 * Fungsi untuk memperbarui atau menambah data inventaris.
 *
 * @param int $ID_Barang
 * @param int $jumlah
 * @return void
 */
private function updateInventaris($ID_Barang, $jumlah)
{

    // Cari data inventaris berdasarkan ID_Barang dan ID_Karyawan
    $inventaris = DB::table('inventaris')
        ->where('ID_Barang', $ID_Barang)
        ->first();

    if (!$inventaris) {
        // Jika barang belum ada di inventaris, tambahkan data baru
        DB::table('inventaris')->insert([
            'ID_Barang' => $ID_Barang,
            'Jumlah_Barang_Aktual' => $jumlah,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    } else {
        // Jika barang sudah ada, update jumlah barang aktualnya
        DB::table('inventaris')
            ->where('ID_Barang', $ID_Barang)
            ->update([
                'Jumlah_Barang_Aktual' => $inventaris->Jumlah_Barang_Aktual - $jumlah,
                'updated_at' => now(),
            ]);
    }
}


    // Menampilkan detail pengeluaran
    public function show($id)
    {
        $pengeluaran = Pengeluaran::with(['barang', 'karyawan'])->findOrFail($id);
        return view('pengeluarans.show', compact('pengeluaran'));
    }

    // Menampilkan form edit pengeluaran
    public function edit($id)
    {
        $pengeluaran = Pengeluaran::with('details.barang')->findOrFail($id);
        $barangs = Barang::all();
        $karyawans = Karyawan::all();
        return view('view-pengeluaran.edit', compact('pengeluaran', 'barangs', 'karyawans'));
    }

    // Mengupdate pengeluaran
    public function update(Request $request, $id)
{
    $pengeluaran = Pengeluaran::with('details')->findOrFail($id);

    // Rollback stok sebelumnya menggunakan metode updateInventaris
    foreach ($pengeluaran->details as $detail) {
        $this->updateInventaris($detail->ID_Barang, -$detail->qty); // Tambahkan stok lama
    }

    // Update data pengeluaran
    $pengeluaran->update([
        'No_Faktur' => $request->No_Faktur,
        'Tanggal_Pengeluaran' => $request->Tanggal_Pengeluaran,
    ]);

    // Hapus detail lama
    $pengeluaran->details()->delete();

    // Tambahkan detail baru dan perbarui stok menggunakan metode updateInventaris
    foreach ($request->barang as $barang) {
        $pengeluaran->details()->create([
            'ID_Barang' => $barang['ID_Barang'],
            'qty' => $barang['qty'],
            'Harga_Jual' => $barang['Harga'],
            'Diskon' => $barang['Diskon'],
            'Subtotal' => $barang['Subtotal']
        ]);

        // Tambahkan stok baru
        $this->updateInventaris($barang['ID_Barang'], $barang['qty']);
    }

    return redirect()->route('pengeluaran-index-page')->with('success', 'pengeluaran berhasil diperbarui.');
}

    // Menghapus pengeluaran
    public function destroy($id)
    {
        $pengeluaran = Pengeluaran::with('details')->findOrFail($id);
        foreach ($pengeluaran->details as $detail) {
            $this->updateInventaris($detail->ID_Barang, -$detail->qty); // Tambahkan stok lama
        }
        $pengeluaran->delete();

        return redirect()->route('pengeluaran-index-page')->with('success', 'Pengeluaran berhasil dihapus.');
    }


    public function generateInvoice($id)
    {
    // Ambil data pengeluaran berdasarkan ID
    $pengeluaran = Pengeluaran::with(['details.barang', 'karyawan'])->findOrFail($id);

    // Data tambahan
    $karyawan = Auth::guard('karyawan')->user(); // Karyawan yang sedang login

    // Ganti karakter yang tidak diizinkan dalam nama file (misal "/")
    $safeNoFaktur = str_replace(['/', '\\'], '_', $pengeluaran->No_Faktur);

    // Render view ke PDF menggunakan DomPDF dengan orientasi landscape
    $pdf = Pdf::loadView('view-pengeluaran.invoice', compact('pengeluaran', 'karyawan'))
              ->setPaper('a4', 'landscape');  // Atur ukuran kertas dan orientasi

    // Return file PDF untuk diunduh atau ditampilkan
    return $pdf->stream("invoice_pengeluaran_{$safeNoFaktur}.pdf");
    }

    

public function generateSuratJalan($id)
{

   
    // Ambil data pengeluaran berdasarkan ID
    $pengeluaran = Pengeluaran::with(['details.barang', 'karyawan'])->findOrFail($id);

    // Data tambahan
    $karyawan = Auth::guard('karyawan')->user(); // Karyawan yang sedang login

    $safeNoFaktur = str_replace(['/', '\\'], '_', $pengeluaran->No_Faktur);

    // Render view ke PDF menggunakan DomPDF
    $pdf = Pdf::loadView('view-pengeluaran.surjal', compact('pengeluaran', 'karyawan'));

    // Return file PDF untuk diunduh atau ditampilkan
    return $pdf->stream("surat_jalan_pengeluaran_{$pengeluaran->safeNo_Faktur}.pdf");
}
}
