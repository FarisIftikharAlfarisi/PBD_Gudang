<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Rak;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    // Menampilkan daftar barang
    public function index()
    {
        $barangs = Barang::with(['kategori', 'rak'])->get();
        $kategoris = Kategori::all(); // Retrieve all categories
        $raks = Rak::all(); // Retrieve all racks
        return view('view-barang.index', compact('barangs', 'kategoris', 'raks'));
    }

    // Menampilkan form untuk membuat barang baru
    public function create()
    {
        $kategoris = Kategori::all(); // Daftar kategori untuk dropdown
        $raks = Rak::all(); // Daftar rak untuk dropdown
        return view('view-barang.create', compact('kategoris', 'raks'));
    }

    // Menyimpan barang baru
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'ID_Kategori' => 'required|exists:kategoris,ID_Kategori',
            'ID_Rak' => 'required|exists:raks,ID_Rak',
            'Nama_Barang' => 'required|max:255',
            'Deskripsi' => 'required',
            'Satuan' => 'required|max:50',
            'Harga_Pokok' => 'required|numeric|min:0',
            'Harga_Jual' => 'required|numeric|min:0',
            'Kode_Part' => 'required|max:100',
            'Merek' => 'required|max:100',
        ]);

        // Menyimpan data barang
        Barang::create($request->all());

        return redirect()->route('barang-index-page')->with('success', 'Barang berhasil ditambahkan.');
    }

    // Menampilkan detail barang
    public function show($id)
    {
        $barang = Barang::with(['kategori', 'rak'])->findOrFail($id);
        return view('barangs.show', compact('barang'));
    }

    // Menampilkan form edit barang
    public function edit($id)
    {
        $barang = Barang::findOrFail($id);
        $kategoris = Kategori::all(); // Retrieve all categories
        $raks = Rak::all(); // Retrieve all racks
        return view('barang-update', compact('barang', 'kategoris', 'raks'));
    }

    // Mengupdate barang
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'ID_Kategori' => 'required|exists:kategoris,ID_Kategori',
            'ID_Rak' => 'required|exists:raks,ID_Rak',
            'Nama_Barang' => 'required|max:255',
            'Deskripsi' => 'required',
            'Satuan' => 'required|max:50',
            'Harga_Pokok' => 'required|numeric|min:0',
            'Harga_Jual' => 'required|numeric|min:0',
            'Kode_Part' => 'required|max:100',
            'Merek' => 'required|max:100',
        ]);

        // Update data barang
        $barang = Barang::findOrFail($id);
        $barang->update($request->all());

        return redirect()->route('barang-index-page')->with('success', 'Barang berhasil diupdate.');
    }

    // Menghapus barang
    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();

        return redirect()->route('barang-index-page')->with('success', 'Barang berhasil dihapus.');
    }
}
