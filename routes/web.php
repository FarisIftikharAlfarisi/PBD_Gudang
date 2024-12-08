<?php

use App\Http\Controllers\AnalyticsController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\GudangController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PenerimaanController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\RakController;

// Route::get('/', function () {
//     if (Auth::check()) {
//         return redirect()->route('analisis');
//     }
//     return redirect()->route('login-page');
// });

Route::get('/login', [AuthenticationController::class,'login_view'])->name('login-page');
Route::post('/login-process', [AuthenticationController::class,'login'])->name('login-process');
Route::get('/logout', [AuthenticationController::class,'logout'])->name('logout');



//route untuk yang sudah login

Route::middleware([App\Http\Middleware\KaryawanAuth::class, 'cek_role:Staff'])->group(function (){
    //kasir routes
    Route::get('/dashboard-kasir', [KasirController::class,'index'])->name('kasir-index-page');
    Route::post('/store-pesanan', [KasirController::class,'storePesanan'])->name('store-pesanan');
    //end kasir routes
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
    Route::get('/dashboard/karyawan', [KaryawanController::class,'index'])->name('karyawan-index-page');
    Route::get('/dashboard/karyawan/karyawan-baru', [KaryawanController::class,'create'])->name('karyawan-create-page');
    Route::post('/dashboard/karyawan/create-process', [KaryawanController::class,'store'])->name('karyawan-store-process');
    Route::put('/dashboard/karyawan/update/{id}', [KaryawanController::class, 'update'])->name('karyawan-update');
    Route::delete('/dashboard/karyawan/delete/{id}', [KaryawanController::class,'destroy'])->name('karyawan-delete');

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


    //pengeluaran routes
    Route::get('/dashboard/pengeluaran', [PengeluaranController::class,'index'])->name('pengeluaran-index-page');
    Route::get('/dashboard/pengeluaran/pengeluaran-baru', [PengeluaranController::class,'create'])->name('pengeluaran-create-page');
    Route::post('/dashboard/pengeluaran/create-process', [PengeluaranController::class,'store'])->name('pengeluaran-store-process');

});


