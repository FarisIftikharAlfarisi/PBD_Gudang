<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\GudangController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PenerimaanController;
use App\Http\Controllers\RakController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthenticationController::class,'login_view'])->name('login-page');
Route::post('/login-process', [AuthenticationController::class,'login'])->name('login-process');
Route::get('/logout', [AuthenticationController::class,'logout'])->name('logout');

//route untuk yang sudah login
Route::group(['middleware'=>'auth'],function(){

    Route::resource('suppliers', SupplierController::class);

    Route::get('/dashboard', [KaryawanController::class,'dashboard_analitics'])->name('Dashboard');
    Route::get('/dashboard/barang', [BarangController::class,'index'])->name('barang-index-page');
    Route::get('/dashboard/barang/kategori', [KategoriController::class,'index'])->name('kategori-index-page');
    Route::put('/dashboard/barang/kategori/update/{id}', [KategoriController::class,'update'])->name('kategori-update');
    Route::delete('/dashboard/barang/kategori/delete/{id}', [KategoriController::class,'destroy'])->name('kategori-delete');

    //karyawan routes
    Route::get('/dashboard/karyawan', [KaryawanController::class,'index'])->name('karyawan-index-page');
    Route::get('/dashboard/karyawan', [KaryawanController::class,'index'])->name('karyawan-index-page');

    //supplier routes
    Route::get('/dashboard/supplier',[SupplierController::class,'index'])->name('supplier-index-page');

    // penyimpanan routes (gudang sama rak)
    Route::get('dashboard/gudang',[GudangController::class,'index'])->name('gudang-index-page');
    Route::get('dashboard/rak',[RakController::class,'index'])->name('rak-index-page');

    //penerimaan routes
    Route::get('/dashboard/penerimaan', [PenerimaanController::class,'index'])->name('penerimaan-index-page');
    Route::get('/dashboard/penerimaan/penerimaan-baru', [PenerimaanController::class,'create'])->name('penerimaan-create-page');
    Route::post('/dashboard/penerimaan/create-process', [PenerimaanController::class,'store'])->name('penerimaan-store-process');
});


