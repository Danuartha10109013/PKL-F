<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }
    public function login()
    {
        return view('pages.login');
    }

    public function login_proses(Request $request)
    {
        // dd($request->all());
        $loginType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $data = [
            $loginType => $request->username,
            'password' => $request->password,
        ];

        if (Auth::attempt($data)) {
            $user = Auth::user();
            
            // Cek peran pengguna setelah login berhasil
            if ($user->active == 0) {
                return redirect()->route('auth.login')->with('error', 'Your Account was inactive, contact your admin');
            }
        
            // Redirect sesuai peran pengguna jika status aktif
            if ($user->role == 0) {
                return redirect()->route('hc.dashboard');
            } elseif ($user->role == 1) {
                return redirect()->route('pegawai.dashboard');
            } elseif ($user->role == 2) {
                return redirect()->route('kapro.dashboard');
            } elseif ($user->role == 3) {
                return redirect()->route('manajerhc.dashboard');
            }elseif ($user->role == 4) {
                return redirect()->route('pusat.dashboard');
            }
        } else {
            // Redirect kembali ke halaman login jika gagal
            return redirect()->route('auth.login')->with('error', 'Username atau Password anda salah!');
        }
    }


    public function logout()
    {
        Auth::logout();
        return redirect()->route('auth.login')->with('succes', 'Kamu berhasil Logout');
    }
}
