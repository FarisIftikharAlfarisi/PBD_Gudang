<?php

namespace App\Http\Controllers;

use App\Models\Rak;
use App\Models\Gudang;
use Illuminate\Http\Request;

class RakController extends Controller
{
    // Menampilkan daftar rak
    public function index()
    {
        $raks = Rak::with('gudang')->get();
        return view('view-rak.index', compact('raks'));
    }

    // Menampilkan form untuk membuat rak baru
    public function create()
    {
        $gudangs = Gudang::all(); // Mengambil daftar gudang untuk dropdown
        return view('raks.create', compact('gudangs'));
    }

    // Menyimpan rak baru
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'Nomor_Rak' => 'required|max:50',
            'Lokasi_Rak' => 'required',
            'Kapasitas_Rak' => 'required|integer',
            'Status_Rak' => 'required|in:available,maintenance',
            'ID_Gudang' => 'required|exists:gudangs,ID_Gudang',
        ]);

        // Menyimpan data rak
        Rak::create($request->all());

        return redirect()->route('raks.index')->with('success', 'Rak berhasil ditambahkan.');
    }

    // Menampilkan detail rak
    public function show($id)
    {
        $rak = Rak::with('gudang')->findOrFail($id);
        return view('raks.show', compact('rak'));
    }

    // Menampilkan form edit rak
    public function edit($id)
    {
        $rak = Rak::findOrFail($id);
        $gudangs = Gudang::all();
        return view('raks.edit', compact('rak', 'gudangs'));
    }

    // Mengupdate rak
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'Nomor_Rak' => 'required|max:50',
            'Lokasi_Rak' => 'required',
            'Kapasitas_Rak' => 'required|integer',
            'Status_Rak' => 'required|in:available,maintenance',
            'ID_Gudang' => 'required|exists:gudangs,ID_Gudang',
        ]);

        // Update data rak
        $rak = Rak::findOrFail($id);
        $rak->update($request->all());

        return redirect()->route('raks.index')->with('success', 'Rak berhasil diupdate.');
    }

    // Menghapus rak
    public function destroy($id)
    {
        $rak = Rak::findOrFail($id);
        $rak->delete();

        return redirect()->route('raks.index')->with('success', 'Rak berhasil dihapus.');
    }
}
