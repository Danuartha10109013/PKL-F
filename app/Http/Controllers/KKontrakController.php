<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KKontrakController extends Controller
{
    public function index(){
        return view('pages.hc.kelolakontrak.index');
    }

}
