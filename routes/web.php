<?php

use App\Http\Controllers\AnalyticsController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\GudangController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PenerimaanController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\RakController;
use App\Http\Controllers\ReportController;

// Route::get('/', function () {
//     if (Auth::check()) {
//         return redirect()->route('analisis');
//     }
//     return redirect()->route('login-page');
// });
Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [AuthenticationController::class,'login_view'])->name('login-page');
Route::post('/login-process', [AuthenticationController::class,'login'])->name('login-process');
Route::get('/logout', [AuthenticationController::class,'logout'])->name('logout');

Route::get('/dashboard/karyawan', [KaryawanController::class,'index'])->name('karyawan-index-page');
Route::get('/dashboard/karyawan/karyawan-baru', [KaryawanController::class,'create'])->name('karyawan-create-page');
Route::put('/dashboard/karyawan/update/{id}', [KaryawanController::class, 'update'])->name('karyawan-update');
Route::delete('/dashboard/karyawan/delete/{id}', [KaryawanController::class,'destroy'])->name('karyawan-delete');
Route::post('/dashboard/karyawan/create-process', [KaryawanController::class,'store'])->name('karyawan-store-process');


//route untuk yang sudah login

//route untuk profil bagi semua karyawan, tapi harus sudah login
Route::middleware([App\Http\Middleware\KaryawanAuth::class])->group(function (){
    Route::get('/profil', [KaryawanController::class,'profil'])->name('profil');
    
});
   
    Route::middleware([App\Http\Middleware\KaryawanAuth::class, 'cek_role:Staff'])->group(function (){
    //kasir routes
    Route::get('/dashboard-kasir', [KasirController::class,'index'])->name('kasir-index-page');
    Route::get('/get-loyal-customer', [KasirController::class,'daftar_customer'])->name('daftar-customer');
    Route::post('/store-pesanan', [KasirController::class,'storePesanan'])->name('store-pesanan');
    Route::put('/update-pesanan/{Nomor_Nota}', [KasirController::class,'updatePesanan'])->name('update-pesanan');
    Route::get('/dashboard-kasir/nota', [KasirController::class,'printNota'])->name('kasir-nota-page');
    Route::get('/dashboard-kasir/riwayat', [KasirController::class,'riwayat'])->name('riwayat-pembelian-kasir');
    Route::get('/barang', [BarangController::class,'index'])->name('barang-index-page');
    Route::get('/dashboard-kasir/cetak-nota/{id}', [KasirController::class, 'generateNota'])->name('cetak-nota');
    Route::get('/transaksi/detail/{id}', [KasirController::class, 'getDetail'])->name('transaksi-detail');


    

});


//Hak akses Owner
Route::middleware([App\Http\Middleware\KaryawanAuth::class, 'cek_role:Owner'])->group(function (){

    Route::resource('suppliers', SupplierController::class);

    Route::get('/dashboard', [AnalyticsController::class,'analytics'])->name('analisis');

    Route::get('/dashboard/barang', [BarangController::class,'index'])->name('barang-index-page');
    Route::get('/dashboard/barang/barang-baru', [BarangController::class,'create'])->name('barang-create-page');
    Route::post('/dashboard/barang/create-process', [BarangController::class,'store'])->name('barang-store-process');
    Route::put('/dashboard/barang/update/{id}', [BarangController::class, 'update'])->name('barang-update');
    Route::delete('/dashboard/barang/delete/{id}', [BarangController::class,'destroy'])->name('barang-delete');


    Route::get('/dashboard/barang/kategori', [KategoriController::class,'index'])->name('kategori-index-page');
    Route::get('/dashboard/kategori/kategori-baru', [KategoriController::class,'create'])->name('kategori-create-page');
    Route::post('/dashboard/kategori/create-process', [KategoriController::class,'store'])->name('kategori-store-process');
    Route::put('/dashboard/barang/kategori/update/{id}', [KategoriController::class,'update'])->name('kategori-update');
    Route::delete('/dashboard/barang/kategori/delete/{id}', [KategoriController::class,'destroy'])->name('kategori-delete');

    //karyawan routes
    
    //end karyawan routes

    //supplier routes
    Route::get('/dashboard/supplier',[SupplierController::class,'index'])->name('supplier-index-page');
    Route::get('/dashboard/supplier/supplier-baru', [SupplierController::class,'create'])->name('supplier-create-page');
    Route::post('/dashboard/supplier/create-process', [SupplierController::class,'store'])->name('supplier-store-process');
    Route::put('/dashboard/supplier/update/{id}', [SupplierController::class, 'update'])->name('supplier-update');
    Route::delete('/dashboard/supplier/delete/{id}', [SupplierController::class,'destroy'])->name('supplier-delete');

    // penyimpanan routes (gudang sama rak)
    Route::get('dashboard/gudang',[GudangController::class,'index'])->name('gudang-index-page');
    Route::get('/dashboard/gudang/gudang-baru', [GudangController::class,'create'])->name('gudang-create-page');
    Route::post('/dashboard/gudang/create-process', [GudangController::class,'store'])->name('gudang-store-process');
    Route::put('/dashboard/gudang/update/{id}', [GudangController::class, 'update'])->name('gudang-update');
    Route::delete('/dashboard/gudang/delete/{id}', [GudangController::class,'destroy'])->name('gudang-delete');

    Route::get('dashboard/rak',[RakController::class,'index'])->name('rak-index-page');
    Route::get('/dashboard/rak/rak-baru', [RakController::class,'create'])->name('rak-create-page');
    Route::post('/dashboard/rak/create-process', [RakController::class,'store'])->name('rak-store-process');
    Route::put('/dashboard/rak/update/{id}', [RakController::class, 'update'])->name('rak-update');
    Route::delete('/dashboard/rak/delete/{id}', [RakController::class,'destroy'])->name('rak-delete');

    //penerimaan routes
    Route::get('/dashboard/penerimaan', [PenerimaanController::class,'index'])->name('penerimaan-index-page');
    Route::get('/dashboard/penerimaan/penerimaan-baru', [PenerimaanController::class,'create'])->name('penerimaan-create-page');
    Route::post('/dashboard/penerimaan/create-process', [PenerimaanController::class,'store'])->name('penerimaan-store-process');
    Route::get('/dashboard/penerimaan/update/{id}', [PenerimaanController::class, 'edit'])->name('penerimaan-edit-page');
    Route::put('/dashboard/penerimaan/{id}', [PenerimaanController::class, 'update'])->name('penerimaan-update-process');
    Route::delete('/dashboard/penerimaan/delete/{id}', [PenerimaanController::class,'destroy'])->name('penerimaan-delete');
    Route::get('/dashbaord/penerimaan/{id}/store-to-rak', [PenerimaanController::class, 'storeToRak'])->name('penerimaan-store-to-rak');
    Route::post('/dashboard/penerimaan/{id}/save-to-rak', [PenerimaanController::class, 'saveToRak'])->name('penerimaan-save-to-rak');    


    //pengeluaran routes
    Route::get('/dashboard/pengeluaran', [PengeluaranController::class,'index'])->name('pengeluaran-index-page');
    Route::get('/dashboard/pengeluaran/pengeluaran-baru', [PengeluaranController::class,'create'])->name('pengeluaran-create-page');
    Route::post('/dashboard/pengeluaran/create-process', [PengeluaranController::class,'store'])->name('pengeluaran-store-process');
    Route::get('/dashboard/pengeluaran/update/{id}', [PengeluaranController::class, 'edit'])->name('pengeluaran-edit-page');
    Route::put('/dashboard/pengeluaran/{id}', [PengeluaranController::class, 'update'])->name('pengeluaran-update-process');
    Route::delete('/dashboard/pengeluaran/delete/{id}', [PengeluaranController::class,'destroy'])->name('pengeluaran-delete');
    Route::get('dashboard/pengeluaran/{id}/invoice', [PengeluaranController::class, 'generateInvoice'])->name('pengeluaran-invoice');
    Route::get('dashboard/pengeluaran/{id}/surat-jalan', [PengeluaranController::class, 'generateSuratJalan'])->name('pengeluaran-surat-jalan');

    //Laporan Routes
    Route::get('dashboard/laporan/kasir', [ReportController::class, 'order'])->name('laporan-order-page');
    Route::get('dashboard/laporan/penerimaan', [ReportController::class, 'penerimaan'])->name('laporan-penerimaan-page');
    Route::get('dashboard/laporan/pengeluaran', [ReportController::class, 'pengeluaran'])->name('laporan-pengeluaran-page');

});

// API ROUTES
// // data warehouse API
// Route::prefix('api')->middleware('api')->group(function () {
//     Route::get('/pipeline', [ChatController::class, 'pipeline']);
// });
