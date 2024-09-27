<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashbardController extends Controller
{
    public function hc(){
        return view('pages.hc.index');
    }
    public function pegawai(){
        return view('pages.pegawai.index');
    }
    public function kapro(){
        return view('pages.kapro.index');
    }
    public function manajerhc(){
        return view('pages.manajerhc.index');
    }
    public function pusat(){
        return view('pages.pusat.index');
    }
}
