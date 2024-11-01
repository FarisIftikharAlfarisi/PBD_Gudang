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
        return view('Penerimaan.index', compact('penerimaans'));
    }

    // Menampilkan form untuk membuat penerimaan baru
    public function create()
    {
        $barangs = Barang::all(); // Daftar barang untuk dropdown
        $suppliers = Supplier::all(); // Daftar supplier untuk dropdown
        return view('Penerimaan.create', compact('barangs', 'suppliers'));
    }

    // Menyimpan penerimaan baru
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'No_Faktur' => 'required|max:100',
            'Tanggal_Penerimaan' => 'required|date',
            'ID_Barang' => 'required|exists:barangs,ID_Barang',
            'ID_Supplier' => 'required|exists:suppliers,ID_Supplier',
            'Jumlah' => 'required|integer|min:1',
        ]);

        // Menyimpan data penerimaan
        Penerimaan::create($request->all());

        // Cari record inventaris untuk barang ini dan update jumlah aktual
        $inventaris = Inventaris::where('ID_Barang', $request->ID_Barang)
                                ->where('ID_Karyawan', Auth::user()->ID_Karyawan)
                                ->first();

        // Jika record inventaris tidak ada, buat baru
        if (!$inventaris) {
            Inventaris::create([
                'ID_Barang' => $request->ID_Barang,
                'ID_Karyawan' => Auth::user()->ID_Karyawan, // atau ID karyawan yang relevan
                'Jumlah_Barang_Aktual' => $request->Jumlah,
            ]);
        } else {
            // Jika sudah ada, tambahkan jumlah barang aktual
            $inventaris->Jumlah_Barang_Aktual += $request->Jumlah;
            $inventaris->save();
        }

        return redirect()->route('Penerimaan.index')->with('success', 'Penerimaan berhasil ditambahkan.');
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
        $penerimaan = Penerimaan::findOrFail($id);
        $penerimaan->delete();

        return redirect()->route('Penerimaan.index')->with('success', 'Penerimaan berhasil dihapus.');
    }
}
