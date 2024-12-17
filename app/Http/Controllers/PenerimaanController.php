<?php

namespace App\Http\Controllers;


use App\Models\Barang;
use App\Models\Supplier;
use App\Models\Inventaris;
use App\Models\Penerimaan;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class PenerimaanController extends Controller
{
    // Menampilkan daftar penerimaan
    public function index()
{
    $penerimaans = Penerimaan::with(['supplier','karyawan', 'details.barang'])
        ->orderBy('id_penerimaan', 'desc')
        ->get();
    return view('view-penerimaan.index', compact('penerimaans'));
}



    // Menampilkan form untuk membuat penerimaan baru
    public function create()
    {
        $barangs = Barang::all(); // Daftar barang untuk dropdown
        $suppliers = Supplier::all();
        $karyawans = Karyawan::all(); // Daftar supplier untuk dropdown
        return view('view-penerimaan.create', compact('barangs', 'suppliers','karyawans'));
    }

    // Menyimpan penerimaan baru
    public function store(Request $request)
{
    // Validasi data input
    $request->validate([
        'No_Faktur' => 'required|string|unique:penerimaans,no_faktur',
        'Tanggal_Penerimaan' => 'required|date',
        'ID_Supplier' => 'required|exists:suppliers,ID_Supplier',
        'ID_Barang.*' => 'required|exists:barangs,ID_Barang',
    ]);
    $karyawan = Auth::guard('karyawan')->user(); // Menggunakan guard karyawan
    $karyawan_id = $karyawan->ID_Karyawan;

    // Simpan data utama ke tabel `penerimaans`
    $penerimaanId = DB::table('penerimaans')->insertGetId([
        'No_Faktur' => $request->No_Faktur,
        'Tanggal_Penerimaan' => $request->Tanggal_Penerimaan,
        'ID_Supplier' => $request->ID_Supplier,
        'ID_Karyawan' => $karyawan_id,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    // Simpan detail penerimaan langsung ke tabel `detail_penerimaans`
    $details = [];
    foreach ($request->ID_Barang as $index => $ID_Barang) {
        $details[] = [
            'ID_Penerimaan' => $penerimaanId, // ID dari penerimaan yang baru dibuat
            'ID_Barang' => $ID_Barang,
            'qty' => $request->Jumlah[$index], // Menambahkan qty (Jumlah)
            'created_at' => now(),
            'updated_at' => now(),
        ];

        // Update atau tambah jumlah barang di tabel `inventaris`
        $this->updateInventaris($ID_Barang, $request->Jumlah[$index]);
    }

    // Batch insert ke tabel `detail_penerimaans`
    DB::table('detail_penerimaans')->insert($details);

    // Redirect ke halaman index dengan pesan sukses
    return redirect()->route('penerimaan-index-page')->with('success', 'Penerimaan berhasil disimpan.');
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
                'Jumlah_Barang_Aktual' => $inventaris->Jumlah_Barang_Aktual + $jumlah,
                'updated_at' => now(),
            ]);
    }
}


    // Menampilkan detail penerimaan
    public function show($id)
    {
        $penerimaan = Penerimaan::with(['barang', 'supplier'])->findOrFail($id);
        return view('penerimaans.show', compact('penerimaan'));
    }

    // Menampilkan form edit penerimaan
    public function edit($id)
    {
        $penerimaan = Penerimaan::with('details.barang')->findOrFail($id);
        $suppliers = Supplier::all();
        $barangs = Barang::all();

        return view('view-penerimaan.edit', compact('penerimaan', 'suppliers', 'barangs'));
    }

    public function update(Request $request, $id)
{
    $penerimaan = Penerimaan::with('details')->findOrFail($id);

    // Rollback stok sebelumnya menggunakan metode updateInventaris
    foreach ($penerimaan->details as $detail) {
        $this->updateInventaris($detail->ID_Barang, -$detail->qty); // Kurangi stok sebelumnya
    }

    // Update data penerimaan
    $penerimaan->update([
        'No_Faktur' => $request->No_Faktur,
        'Tanggal_Penerimaan' => $request->Tanggal_Penerimaan,
        'ID_Supplier' => $request->ID_Supplier,
    ]);

    // Hapus detail lama
    $penerimaan->details()->delete();

    // Tambahkan detail baru dan perbarui stok menggunakan metode updateInventaris
    foreach ($request->barang as $barang) {
        $penerimaan->details()->create([
            'ID_Barang' => $barang['ID_Barang'],
            'qty' => $barang['qty'],
        ]);

        // Tambahkan stok baru
        $this->updateInventaris($barang['ID_Barang'], $barang['qty']);
    }

    return redirect()->route('penerimaan-index-page')->with('success', 'Penerimaan berhasil diperbarui.');
}
     // Menghapus pengeluaran
     public function destroy($id)
     {
         $penerimaan = Penerimaan::findOrFail($id);
         $penerimaan->delete();
 
         return redirect()->route('penerimaan-index-page')->with('success', 'Penerimaan berhasil dihapus.');
     }
 


}
