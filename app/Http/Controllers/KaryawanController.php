<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class KaryawanController extends Controller
{
    // Menampilkan daftar karyawan
    public function index()
    {
        $karyawans = Karyawan::all();
        return view('view-karyawan.index', compact('karyawans'));
    }

    public function profil(){
        //dapatkan data karyawan yang sedang login
        $data_karyawan = Auth::guard('karyawan')->user();
        return view('view-user-profile.index', compact('data_karyawan'));
    }

    // Menampilkan form untuk membuat karyawan baru
    public function create()
    {

        return view('view-karyawan.create');
    }

    // Menyimpan karyawan baru
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'Nomor_karyawan' => 'required|max:80',
            'email' => 'required|email|max:80|unique:karyawans',
            'password' => 'required|min:6',
            'Nama_Karyawan' => 'required|max:255',
            'Alamat' => 'required',
            'Nomor_Telepon' => 'required|max:15',
            'Jabatan' => 'required|max:100',
        ]);

        // Simpan data karyawan dengan password yang di-hash
        Karyawan::create([
            'Nomor_karyawan' => $request->Nomor_karyawan,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'Nama_Karyawan' => $request->Nama_Karyawan,
            'Alamat' => $request->Alamat,
            'Nomor_Telepon' => $request->Nomor_Telepon,
            'Jabatan' => $request->Jabatan,
        ]);

        return redirect()->route('karyawan-index-page')->with('success', 'Karyawan berhasil ditambahkan.');
    }

    // Menampilkan detail karyawan
    public function show($id)
    {
        $karyawan = Karyawan::findOrFail($id);
        return view('karyawans.show', compact('karyawan'));
    }

    // Menampilkan form edit karyawan
    public function edit($id)
    {
        $karyawan = Karyawan::findOrFail($id);
        return view('karyawans.edit', compact('karyawan'));
    }

    // Mengupdate karyawan
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'Nomor_karyawan' => 'required|max:80',
            'email' => 'required|email|max:80|unique:karyawans,email,' . $id . ',ID_Karyawan',
            'Nama_Karyawan' => 'required|max:255',
            'Alamat' => 'required',
            'Nomor_Telepon' => 'required|max:15',
            'Jabatan' => 'required|max:100',
        ]);

        // Update data karyawan
        $karyawan = Karyawan::findOrFail($id);
        $karyawan->update([
            'Nomor_karyawan' => $request->Nomor_karyawan,
            'email' => $request->email,
            'Nama_Karyawan' => $request->Nama_Karyawan,
            'Alamat' => $request->Alamat,
            'Nomor_Telepon' => $request->Nomor_Telepon,
            'Jabatan' => $request->Jabatan,
        ]);

        // Jika password diisi, hash dan update
        if ($request->password) {
            $karyawan->password = Hash::make($request->password);
            $karyawan->save();
        }

        return redirect()->route('karyawan-index-page')->with('success', 'Karyawan berhasil diupdate.');
    }

    // Menghapus karyawan
    public function destroy($id)
    {
        $karyawan = Karyawan::findOrFail($id);
        $karyawan->delete();

        return redirect()->route('karyawan-index-page')->with('success', 'Karyawan berhasil dihapus.');
    }

    public function updatePassword(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'password' => 'required|min:6',
        ]);

        // Update password karyawan
        $karyawan = Karyawan::findOrFail($id);
        $karyawan->password = Hash::make($request->password);
        $karyawan->save();

        return redirect()->route('profil')->with('success', 'Password berhasil diubah.');
    }
}
