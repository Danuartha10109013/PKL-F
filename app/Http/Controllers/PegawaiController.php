<?php

namespace App\Http\Controllers;

use App\Models\KontrakM;
use App\Models\ProjectM;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PegawaiController extends Controller
{
    public function project(){
        $userId = Auth::user()->id;

        // Mencari data di mana pegawai_id mengandung ID user aktif
        $data = ProjectM::where('pegawai_id', 'LIKE', '%"'.$userId.'"%')
            ->orWhere('pegawai_id', 'LIKE', '%,'.$userId.',%')
            ->orWhere('pegawai_id', 'LIKE', $userId.',%')
            ->orWhere('pegawai_id', 'LIKE', '%,'.$userId)
            ->orWhere('pegawai_id', '=', $userId)
            ->get();
        // dd($data);
        return view('pages.pegawai.project.index',compact('data'));
    }
    public function kontrak(){
        $data = KontrakM::where('user_id', Auth::user()->id)->get();
        return view('pages.pegawai.kontrak.index',compact('data'));
    }
}
