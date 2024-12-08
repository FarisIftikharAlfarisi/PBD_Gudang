<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class KasirController extends Controller
{
    public function index(){
        $barang = Barang::all();
        return view("view-kasir.index", compact('barang'));
    }

    public function storePesanan(Request $request){
        dd($request->all());
    }

}
