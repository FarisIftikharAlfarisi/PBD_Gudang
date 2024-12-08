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
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::guard('karyawan')->attempt($request->only('email', 'password'))) {
            return redirect()->route('analisis');
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
