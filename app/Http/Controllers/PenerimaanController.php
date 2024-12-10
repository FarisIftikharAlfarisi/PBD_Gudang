<?php

namespace App\Http\Controllers;


use App\Models\Barang;
use App\Models\Supplier;
use App\Models\Inventaris;
use App\Models\Penerimaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class PenerimaanController extends Controller
{
    // Menampilkan daftar penerimaan
    public function index()
{
    $penerimaans = Penerimaan::with(['supplier', 'details.barang'])
        ->orderBy('id_penerimaan', 'desc')
        ->get();
    return view('view-penerimaan.index', compact('penerimaans'));
}



    // Menampilkan form untuk membuat penerimaan baru
    public function create()
    {
        $barangs = Barang::all(); // Daftar barang untuk dropdown
        $suppliers = Supplier::all(); // Daftar supplier untuk dropdown
        return view('view-penerimaan.create', compact('barangs', 'suppliers'));
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

    // Simpan data utama ke tabel `penerimaans`
    $penerimaanId = DB::table('penerimaans')->insertGetId([
        'No_Faktur' => $request->No_Faktur,
        'Tanggal_Penerimaan' => $request->Tanggal_Penerimaan,
        'ID_Supplier' => $request->ID_Supplier,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    // Simpan detail penerimaan langsung ke tabel `detail_penerimaans`
    $details = [];
    foreach ($request->ID_Barang as $index => $ID_Barang) {
        $details[] = [
            'ID_Penerimaan' => $penerimaanId, // ID dari penerimaan yang baru dibuat
            'ID_Barang' => $ID_Barang,
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
    $inventaris = DB::table('inventaris')
        ->where('ID_Barang', $ID_Barang)
        ->where('ID_Karyawan', Auth::user()->ID_Karyawan)
        ->first();

    if (!$inventaris) {
        // Jika barang belum ada di inventaris, tambahkan
        DB::table('inventaris')->insert([
            'ID_Barang' => $ID_Barang,
            'ID_Karyawan' => Auth::user()->ID_Karyawan,
            'Jumlah_Barang_Aktual' => $jumlah,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    } else {
        // Jika sudah ada, perbarui jumlah barang
        DB::table('inventaris')
            ->where('ID_Barang', $ID_Barang)
            ->where('ID_Karyawan', Auth::user()->ID_Karyawan)
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
        $penerimaan = Penerimaan::findOrFail($id);

        $penerimaan->update([
            'No_Faktur' => $request->No_Faktur,
            'Tanggal_Penerimaan' => $request->Tanggal_Penerimaan,
            'ID_Supplier' => $request->ID_Supplier,
            

        ]);

        // Delete old details
        $penerimaan->details()->delete();

        // Add new details
        foreach ($request->barang as $barang) {
            $penerimaan->details()->create([
                'ID_Barang' => $barang['ID_Barang'],
                'qty' => $barang['qty'],
            ]);
        }

        return redirect()->route('penerimaan-index-page')->with('success', 'Penerimaan berhasil diperbarui.');
    }


    // Menghapus penerimaan
    public function destroy($id)
    {
        // Cari penerimaan yang akan dihapus
        $penerimaan = Penerimaan::findOrFail($id);
    
        // Hapus semua detail terkait penerimaan ini
        $penerimaan->details()->delete();
    
        // Perbarui inventaris jika diperlukan
        foreach ($penerimaan->details as $detail) {
            $inventaris = Inventaris::where('ID_Barang', $detail->ID_Barang)
                                    ->where('ID_Karyawan', Auth::user()->ID_Karyawan)
                                    ->first();
    
            if ($inventaris) {
                // Kurangi jumlah barang aktual dengan jumlah penerimaan
                $inventaris->Jumlah_Barang_Aktual -= $detail->qty;
                if ($inventaris->Jumlah_Barang_Aktual < 0) {
                    $inventaris->Jumlah_Barang_Aktual = 0;
                }
                $inventaris->save();
            }
        }
    
        // Hapus penerimaan
        $penerimaan->delete();
    
        return redirect()->route('penerimaan-index-page')->with('success', 'Penerimaan berhasil dihapus.');
    }
    

}
