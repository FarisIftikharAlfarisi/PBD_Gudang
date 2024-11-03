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
        return view('view-pengeluaran.index', compact('pengeluarans'));
    }

    // Menampilkan form untuk membuat pengeluaran baru
    public function create()
    {
        $barangs = Barang::all(); // Daftar barang untuk dropdown
        $karyawans = Karyawan::all(); // Daftar karyawan untuk dropdown
        return view('view-pengeluaran.create', compact('barangs', 'karyawans'));
    }

    // Menyimpan pengeluaran baru
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'No_Faktur' => 'required|max:100',
            'Tanggal_Pengeluaran' => 'required|date',
            'ID_Barang' => 'required|array|min:1',
            'ID_Barang.*' => 'required|exists:barangs,ID_Barang',
            'Jumlah' => 'required|array|min:1',
            'Jumlah.*' => 'required|integer|min:1',
            'Nama_Penerima' => 'required|max:255',
            'Tujuan' => 'required|max:255',
        ]);

        // Iterasi untuk setiap barang yang dikeluarkan
        foreach ($request->ID_Barang as $index => $ID_Barang) {
            $jumlah = $request->Jumlah[$index];

            // Cari record inventaris untuk barang ini dan update jumlah aktual
            $inventaris = Inventaris::where('ID_Barang', $ID_Barang)
                                    ->where('ID_Karyawan', Auth::user()->ID_Karyawan)
                                    ->first();

            if ($inventaris && $inventaris->Jumlah_Barang_Aktual >= $jumlah) {
                // Kurangi jumlah barang aktual
                $inventaris->Jumlah_Barang_Aktual -= $jumlah;
                $inventaris->save();

                // Simpan data pengeluaran per item
                Pengeluaran::create([
                    'No_Faktur' => $request->No_Faktur,
                    'Tanggal_Pengeluaran' => $request->Tanggal_Pengeluaran,
                    'ID_Barang' => $ID_Barang,
                    'Jumlah' => $jumlah,
                    'ID_Karyawan' => Auth::user()->ID_Karyawan,
                    'Nama_Penerima' => $request->Nama_Penerima,
                    'Tujuan' => $request->Tujuan,
                ]);
            } else {
                // Jika stok tidak mencukupi, hentikan proses dan beri pesan error
                return redirect()->back()->withErrors("Stok barang tidak mencukupi.");
            }
        }

        return redirect()->route('pengeluaran-index-page')->with('success', 'Pengeluaran berhasil ditambahkan.');
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
