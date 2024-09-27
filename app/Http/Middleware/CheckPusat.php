<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckPusat
{
    public function handle($request, Closure $next)
    {
        // Periksa apakah pengguna adalah pusat (role = 4)
        if (Auth::check()) {
            if (Auth::user()->role == 4){
                return $next($request);
            }
            return response()->view('errors.custom', ['message' => 'Anda Bukan Admin'], 403);
        }
        return redirect('/');; // Ganti dengan kode status atau rute yang sesuai
    }
}
