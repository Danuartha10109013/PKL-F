<?php

namespace App\Http\Controllers;

use App\Models\LaporanM;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function laporan($id){
        $ids = LaporanM::where('user_id',$id)->value('id');
        // dd($id);
        $laporan = LaporanM::find($ids);
        return view('pages.kapro.project.laporan',compact('laporan'));
    }
}
