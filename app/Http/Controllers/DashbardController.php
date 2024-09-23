<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashbardController extends Controller
{
    public function admin(){
        return view('pages.admin.index');
    }
    public function pegawai(){
        return view('pages.pegawai.index');
    }
}
