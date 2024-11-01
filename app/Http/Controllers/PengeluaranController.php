<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Karyawan;
use App\Models\Inventaris;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengeluaranController extends Controller
{
    // Menampilkan daftar pengeluaran
    public function index()
    {
        $pengeluarans = Pengeluaran::with(['barang', 'karyawan'])->get();
        return view('pengeluarans.index', compact('pengeluarans'));
    }

    // Menampilkan form untuk membuat pengeluaran baru
    public function create()
    {
        $barangs = Barang::all(); // Daftar barang untuk dropdown
        $karyawans = Karyawan::all(); // Daftar karyawan untuk dropdown
        return view('pengeluarans.create', compact('barangs', 'karyawans'));
    }

    // Menyimpan pengeluaran baru
    // Menyimpan pengeluaran baru
public function store(Request $request)
{
    // Validasi input
    $request->validate([
        'No_Faktur' => 'required|max:100',
        'Tanggal_Pengeluaran' => 'required|date',
        'ID_Barang' => 'required|exists:barangs,ID_Barang',
        'ID_Karyawan' => 'required|exists:karyawans,ID_Karyawan',
        'Jumlah' => 'required|integer|min:1',
        'Nama_Penerima' => 'required|max:255',
        'Tujuan' => 'required|max:255',
    ]);

    // Menyimpan data pengeluaran
    Pengeluaran::create($request->all());

    // Cari record inventaris untuk barang ini dan update jumlah aktual
    $inventaris = Inventaris::where('ID_Barang', $request->ID_Barang)
                            ->where('ID_Karyawan', Auth::user()->ID_Karyawan)
                            ->first();

    if ($inventaris && $inventaris->Jumlah_Barang_Aktual >= $request->Jumlah) {
        // Kurangi jumlah barang aktual
        $inventaris->Jumlah_Barang_Aktual -= $request->Jumlah;
        $inventaris->save();
    } else {
        // Jika jumlah barang aktual tidak mencukupi atau inventaris tidak ada
        return redirect()->back()->withErrors('Stok barang tidak mencukupi.');
    }

    return redirect()->route('pengeluarans.index')->with('success', 'Pengeluaran berhasil ditambahkan.');
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
        $pengeluaran = Pengeluaran::findOrFail($id);
        $barangs = Barang::all();
        $karyawans = Karyawan::all();
        return view('pengeluarans.edit', compact('pengeluaran', 'barangs', 'karyawans'));
    }

    // Mengupdate pengeluaran
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'No_Faktur' => 'required|max:100',
            'Tanggal_Pengeluaran' => 'required|date',
            'ID_Barang' => 'required|exists:barangs,ID_Barang',
            'ID_Karyawan' => 'required|exists:karyawans,ID_Karyawan',
            'Jumlah' => 'required|integer|min:1',
            'Nama_Penerima' => 'required|max:255',
            'Tujuan' => 'required|max:255',
        ]);

        // Update data pengeluaran
        $pengeluaran = Pengeluaran::findOrFail($id);
        $pengeluaran->update($request->all());

        return redirect()->route('pengeluarans.index')->with('success', 'Pengeluaran berhasil diupdate.');
    }

    // Menghapus pengeluaran
    public function destroy($id)
    {
        $pengeluaran = Pengeluaran::findOrFail($id);
        $pengeluaran->delete();

        return redirect()->route('pengeluarans.index')->with('success', 'Pengeluaran berhasil dihapus.');
    }
}
