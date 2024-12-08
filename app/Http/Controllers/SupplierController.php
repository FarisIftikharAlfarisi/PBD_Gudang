<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    // Menampilkan daftar supplier
    public function index()
    {
        $suppliers = Supplier::all(); // Mengambil semua data supplier
        return view('view-supplier.index', compact('suppliers'));
    }

    // Menampilkan form untuk membuat supplier baru
    public function create()
    {
        return view('view-supplier.create');
    }

    // Menyimpan supplier baru ke database
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'Nama_Supplier' => 'required|max:255',
            'Alamat' => 'required',
            'Nomor_Telepon' => 'required|max:15',
            'Email' => 'required|email|max:100',
            'Spesialisasi' => 'required',
        ]);

        // Menyimpan data
        Supplier::create($request->all());

        // Redirect dengan pesan sukses
        return redirect()->route('suppliers.index')->with('success', 'Supplier berhasil ditambahkan.');
    }

    // Menampilkan detail supplier
    public function show($id)
    {
        $supplier = Supplier::findOrFail($id);
        return view('suppliers.show', compact('supplier'));
    }

    // Menampilkan form untuk edit supplier
    public function edit($id)
    {
        $supplier = Supplier::findOrFail($id);
        return view('suppliers.edit', compact('supplier'));
    }

    // Mengupdate data supplier
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'Nama_Supplier' => 'required|max:255',
            'Alamat' => 'required',
            'Nomor_Telepon' => 'required|max:15',
            'Email' => 'required|email|max:100',
            'Spesialisasi' => 'required',
        ]);

        // Mengupdate data
        $supplier = Supplier::findOrFail($id);
        $supplier->update($request->all());

        // Redirect dengan pesan sukses
        return redirect()->route('suppliers.index')->with('success', 'Supplier berhasil diupdate.');
    }

    // Menghapus data supplier
    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();

        // Redirect dengan pesan sukses
        return redirect()->route('suppliers.index')->with('success', 'Supplier berhasil dihapus.');
    }
}
