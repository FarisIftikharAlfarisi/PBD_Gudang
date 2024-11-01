<?php

namespace App\Http\Controllers;

use App\Models\Gudang;
use Illuminate\Http\Request;

class GudangController extends Controller
{
    // Menampilkan daftar gudang
    public function index()
    {
        $gudangs = Gudang::all();
        return view('view-gudang.index', compact('gudangs'));
    }

    // Menampilkan form untuk membuat gudang baru
    public function create()
    {
        return view('gudangs.create');
    }

    // Menyimpan gudang baru
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'Nama_Gudang' => 'required|max:255',
            'Lokasi' => 'required',
        ]);

        // Menyimpan data gudang
        Gudang::create($request->all());

        return redirect()->route('gudangs.index')->with('success', 'Gudang berhasil ditambahkan.');
    }

    // Menampilkan detail gudang
    public function show($id)
    {
        $gudang = Gudang::findOrFail($id);
        return view('gudangs.show', compact('gudang'));
    }

    // Menampilkan form edit gudang
    public function edit($id)
    {
        $gudang = Gudang::findOrFail($id);
        return view('gudangs.edit', compact('gudang'));
    }

    // Mengupdate gudang
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'Nama_Gudang' => 'required|max:255',
            'Lokasi' => 'required',
        ]);

        // Update data gudang
        $gudang = Gudang::findOrFail($id);
        $gudang->update($request->all());

        return redirect()->route('gudangs.index')->with('success', 'Gudang berhasil diupdate.');
    }

    // Menghapus gudang
    public function destroy($id)
    {
        $gudang = Gudang::findOrFail($id);
        $gudang->delete();

        return redirect()->route('gudangs.index')->with('success', 'Gudang berhasil dihapus.');
    }
}
