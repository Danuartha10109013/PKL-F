<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PerpanjangController extends Controller
{
    public function index(){
        return view('pages.manajerhc.perpanjang.index');
    }
}
