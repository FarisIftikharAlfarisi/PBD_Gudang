<?php
namespace App\Http\Middleware;

use Closure;
use App\Models\Karyawan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class KaryawanAuth
{
    public function handle($request, Closure $next)
    {
        // Autentikasi pada tabel karyawan
        $email = $request->input('email');
        $password = $request->input('password');

        if ($email && $password) {
            $karyawan = Karyawan::where('email', $email)->first();
            if ($karyawan && Hash::check($password, $karyawan->password)) {
                // Autentikasi sukses
                Auth::guard('karyawan')->login($karyawan);
                return $next($request);
            } else {
                // Autentikasi gagal
                return redirect()->route('login-page')->withErrors(['error' => 'Email atau password salah']);
            }
        }

        // Jika tidak ada input email dan password, lanjutkan ke route selanjutnya
        return $next($request);
    }
}
