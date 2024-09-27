<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KGajiController extends Controller
{
    public function index(){
        return view('pages.hc.kelolagaji.index');
    }
}
