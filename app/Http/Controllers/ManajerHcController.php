<?php

namespace App\Http\Controllers;

use App\Models\HistoryPerpanjanganM;
use App\Models\LaporanM;
use App\Models\PenilaianM;
use App\Models\ProjectM;
use App\Models\User;
use Illuminate\Http\Request;

class ManajerHcController extends Controller
{
    public function index(){
        $data = ProjectM::all();

        return view('pages.manajerhc.project.index',compact('data'));
    }

    public function detail($id){
        $users = User::where('role',1)->get();
        $data = ProjectM::find($id);
        // Assuming $data->user_id contains the JSON array like '["2","7","14"]'
        $user_ids = json_decode($data->pegawai_id, true); // Decode the JSON array into PHP array

        // Check if the user_ids is a valid array before querying
        if (is_array($user_ids) && count($user_ids) > 0) {
            // Use whereIn to get records matching the user_ids
            $cc = PenilaianM::whereIn('id', $user_ids)->get();
        } else {
            $cc = collect(); // If user_ids is empty, return an empty collection
        }

        $lastUser = User::orderBy('no_pegawai', 'desc')->first();

        if ($lastUser && preg_match('/^EMP(\d+)$/', $lastUser->no_pegawai, $matches)) {
            // Increment the number
            $newNoPegawai = 'EMP' . str_pad($matches[1] + 1, 3, '0', STR_PAD_LEFT);
        } else {
            // If no users exist, start with EMP001
            $newNoPegawai = 'EMP001';
        }
        // dd($cc);
        // $user_terlibat = User::where('id',$same)->get()
        return view('pages.kapro.project.detail',compact('data','users','cc','newNoPegawai'));
    }

    public function laporankapro($id){
        $project= ProjectM::find($id);
        $ids = LaporanM::where('user_id',$project->kapro_id)->where('project_id',$project->id)->value('id');
        // dd($ids);
        $laporan = LaporanM::find($ids);
        // dd($ids);
        return view('pages.kapro.project.laporan',compact('laporan','project'));
    }
    public function laporanpegawai($id,$id1){
        $data = ProjectM::whereJsonContains('pegawai_id', $id)->where('id',$id1)->value('id');
        $project= ProjectM::find($data);
        $ids = LaporanM::where('user_id',$id)->where('project_id',$project->id)->value('id');
        // dd($ids);
        $laporan = LaporanM::find($ids);
        // dd($ids);
        return view('pages.kapro.project.laporan',compact('laporan','project'));
    }

    public function history(){
        $data = HistoryPerpanjanganM::orderBy('created_at','desc')->get();
        
        return view('pages.manajerhc.history.index',compact('data'));
    }
}
