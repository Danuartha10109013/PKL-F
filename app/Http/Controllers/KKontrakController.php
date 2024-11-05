<?php

namespace App\Http\Controllers;

use App\Models\KontrakM;
use Illuminate\Http\Request;

class KKontrakController extends Controller
{
    public function index(){
        $data = KontrakM::orderBy('id', 'desc')->paginate(10);

        return view('pages.hc.kelolakontrak.index',compact('data'));
    }

}
