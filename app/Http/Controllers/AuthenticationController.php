<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Karyawan;

class AuthenticationController extends Controller
{
    public function login_view(){
        return view('Authentication.login');
    }

    //proses login handling
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::guard('karyawan')->attempt($request->only('email', 'password'))) {

            if(Auth::guard('karyawan')->user()->Jabatan === "Staff"){
                //route untuk kasir
                return redirect()->route('kasir-index-page');


            }else if( Auth::guard('karyawan')->user()->Jabatan === "Owner" ){
                //route untuk Owner
                return redirect()->route('analisis');
            }else if( Auth::guard('karyawan')->user()->Jabatan === "Manager" ){
                //route untuk Owner
                return redirect()->route('barang-index-page');
            }else{
                return redirect()->route('analisis');
            }
        }else{
            $user_email = Karyawan::where('email', $request->email)->first();
            $user_password = Karyawan::where('password', $request->password)->first();

            if($request->email != $user_email){
                return redirect()->back()->with(['error' => 'Email tidak terdaftar']);
            }else if($request->password != $user_password){
                return redirect()->back()->with(['error'=> 'Password salah']);
            }else{
                return redirect()->back()->with(['error' => 'Email dan Password tidak sesuai']);
            }
        }
        // Jika login gagal, redirect dengan error
        return redirect()->back()->withErrors(['error' => 'Email atau password salah!']);
}

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

    public function reset_pass_view(){
        return view('Authentication.forgot-password');
    }

    //reset pass validation handling
    public function reset_pass(Request $request){

    }

}
