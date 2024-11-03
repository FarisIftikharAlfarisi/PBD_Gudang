<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Supplier;
use App\Models\Inventaris;
use App\Models\Penerimaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenerimaanController extends Controller
{
    // Menampilkan daftar penerimaan
    public function index()
    {
        $penerimaans = Penerimaan::with(['barang', 'supplier'])->get();
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
        $request->validate([
            'No_Faktur' => 'required|string|max:100',
            'Tanggal_Penerimaan' => 'required|date',
            'ID_Supplier' => 'required|exists:suppliers,ID_Supplier',
            'ID_Barang' => 'required|array', // memastikan ini adalah array
            'ID_Barang.*' => 'exists:barangs,ID_Barang', // validasi setiap ID_Barang dalam array
            'Jumlah' => 'required|array',
            'Jumlah.*' => 'integer|min:1',
        ]);

        foreach ($request->ID_Barang as $index => $ID_Barang) {
            Penerimaan::create([
                'No_Faktur' => $request->No_Faktur,
                'Tanggal_Penerimaan' => $request->Tanggal_Penerimaan,
                'ID_Supplier' => $request->ID_Supplier,
                'ID_Barang' => $ID_Barang,
                'Jumlah' => $request->Jumlah[$index], // Jumlah sesuai indeks yang sama
            ]);

            // Update atau tambah jumlah barang di inventaris
            $inventaris = Inventaris::where('ID_Barang', $ID_Barang)
                                    ->where('ID_Karyawan', Auth::user()->ID_Karyawan)
                                    ->first();

            if (!$inventaris) {
                Inventaris::create([
                    'ID_Barang' => $ID_Barang,
                    'ID_Karyawan' => Auth::user()->ID_Karyawan,
                    'Jumlah_Barang_Aktual' => $request->Jumlah[$index],
                ]);
            } else {
                $inventaris->Jumlah_Barang_Aktual += $request->Jumlah[$index];
                $inventaris->save();
            }
        }

        return redirect()->route('penerimaan-index-page')->with('success', 'Penerimaan berhasil disimpan.');
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
        $penerimaan = Penerimaan::findOrFail($id);
        $barangs = Barang::all();
        $suppliers = Supplier::all();
        return view('Penerimaan.edit', compact('penerimaan', 'barangs', 'suppliers'));
    }

    // Mengupdate penerimaan
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'No_Faktur' => 'required|max:100',
            'Tanggal_Penerimaan' => 'required|date',
            'ID_Barang' => 'required|exists:barangs,ID_Barang',
            'ID_Supplier' => 'required|exists:suppliers,ID_Supplier',
            'Jumlah' => 'required|integer|min:1',
        ]);

        // Update data penerimaan
        $penerimaan = Penerimaan::findOrFail($id);
        $penerimaan->update($request->all());

        return redirect()->route('Penerimaan.index')->with('success', 'Penerimaan berhasil diupdate.');
    }

    // Menghapus penerimaan
public function destroy($id)
{
    // Cari penerimaan yang akan dihapus
    $penerimaan = Penerimaan::findOrFail($id);

    $inventaris = Inventaris::where('ID_Barang', $penerimaan->ID_Barang)
                            ->where('ID_Karyawan', Auth::user()->ID_Karyawan)
                            ->first();

    if ($inventaris) {
        // Kurangi jumlah barang aktual dengan jumlah penerimaan
        $inventaris->Jumlah_Barang_Aktual -= $penerimaan->Jumlah;
        if ($inventaris->Jumlah_Barang_Aktual < 0) {
            $inventaris->Jumlah_Barang_Aktual = 0;
        }
        $inventaris->save();
    }

    // Hapus penerimaan
    $penerimaan->delete();

    return redirect()->route('penerimaans.index')->with('success', 'Penerimaan berhasil dihapus.');
}

}
