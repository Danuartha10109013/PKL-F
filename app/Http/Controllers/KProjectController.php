<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KProjectController extends Controller
{
    public function index(){
        return view('pages.hc.kelolaproject.index');
    }
}
