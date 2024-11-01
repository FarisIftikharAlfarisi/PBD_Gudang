<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    // Menampilkan daftar kategori
    public function index()
    {
        $kategoris = Kategori::all();
        return view('view-kategori.index', compact('kategoris'));
    }

    // Menampilkan form untuk membuat kategori baru
    public function create()
    {
        return view('kategoris.create');
    }

    // Menyimpan kategori baru
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'Nama_Kategori' => 'required|max:255',
        ]);

        // Menyimpan data kategori
        Kategori::create($request->all());

        return redirect()->route('kategoris.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    // Menampilkan detail kategori
    public function show($id)
    {
        $kategori = Kategori::findOrFail($id);
        return view('kategoris.show', compact('kategori'));
    }

    // Menampilkan form edit kategori
    public function edit($id)
    {
        $kategori = Kategori::findOrFail($id);
        return view('kategoris.edit', compact('kategori'));
    }

    // Mengupdate kategori
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'Nama_Kategori' => 'required|max:255',
        ]);

        // Update data kategori
        $kategori = Kategori::findOrFail($id);
        $kategori->update($request->all());

        return redirect()->route('kategoris.index')->with('success', 'Kategori berhasil diupdate.');
    }

    // Menghapus kategori
    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);
        $kategori->delete();

        return redirect()->route('kategoris.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
