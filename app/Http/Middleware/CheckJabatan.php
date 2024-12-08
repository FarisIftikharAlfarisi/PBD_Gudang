<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CheckJabatan
{
    public function handle($request,Closure $next, ...$role){
    $user = Auth::guard('karyawan')->user();

    if ($user && $user->Jabatan === $role) {
        return $next($request);
    }
    return $next($request);
}

}
