<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    public function login_view(){
        return view('Authentication.login');
    }

    //proses login handling
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // Cek autentikasi
        if (Auth::attempt($credentials)) {
            // dd('Anda Login');
            return redirect()->intended('dashboard')->with(['success','Selamat Datang, Anda Berhasil Login']);
        }

        // Jika login gagal, redirect kembali dengan pesan error
        return redirect()->back()->withErrors([
            'error' => 'Email atau password salah!',
        ]);
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
