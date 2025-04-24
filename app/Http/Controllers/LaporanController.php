<?php

namespace App\Http\Controllers;

use App\Models\LaporanM;
use App\Models\ProjectM;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function laporan($id,$id1,$m){
        $data = ProjectM::whereJsonContains('pegawai_id', $id)->where('id',$id1)->value('id');
        $project= ProjectM::find($data);
        $ids = LaporanM::where('user_id',$id)->where('project_id',$project->id)->where('created_at',$m)->value('id');
        // dd($ids);
        $laporan = LaporanM::find($ids);
        return view('pages.kapro.project.laporan',compact('laporan'));
    }

    public function laporankapro($id){
        $project= ProjectM::find($id);
        $ids = LaporanM::where('user_id',$project->kapro_id)->where('project_id',$project->id)->value('id');
        // dd($ids);
        $laporan = LaporanM::find($ids);
        // dd($ids);
        return view('pages.kapro.project.laporan',compact('laporan','project'));
    }
}
