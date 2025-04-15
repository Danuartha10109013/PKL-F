<?php

namespace App\Http\Controllers;

use App\Models\KontrakM;
use App\Models\LaporanM;
use App\Models\ProjectM;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PegawaiController extends Controller
{
    public function project( Request $request){
        $userId = Auth::user()->id;
        $search = $request->search;
        // dd($search);
        // Mencari data di mana pegawai_id mengandung ID user aktif
        if($search){
            $data = ProjectM::where('pegawai_id', 'LIKE', '%"'.$userId.'"%')
                ->orWhere('pegawai_id', 'LIKE', '%,'.$userId.',%')
                ->orWhere('pegawai_id', 'LIKE', $userId.',%')
                ->orWhere('pegawai_id', 'LIKE', '%,'.$userId)
                ->orWhere('pegawai_id', '=', $userId)
                ->orWhere('judul', 'LIKE', '%,'.$search)
                ->get();
        }else{
            $data = ProjectM::where('pegawai_id', 'LIKE', '%"'.$userId.'"%')
                ->orWhere('pegawai_id', 'LIKE', '%,'.$userId.',%')
                ->orWhere('pegawai_id', 'LIKE', $userId.',%')
                ->orWhere('pegawai_id', 'LIKE', '%,'.$userId)
                ->orWhere('pegawai_id', '=', $userId)
                ->get();
        }
        // dd($data);
        return view('pages.pegawai.project.index',compact('data'));
    }
    public function kontrak(){
        $datas = KontrakM::where('user_id', Auth::user()->id)->value('id');
        // dd($datas);
        $data = KontrakM::find($datas);
        return view('pages.pegawai.kontrak.index',compact('data'));
    }

    public function laporan($id){
        $data = ProjectM::find($id);
        $ids = LaporanM::where('project_id',$id)->where('user_id',Auth::user()->id)->value('id'); 
        // dd($ids);
        $laporan = LaporanM::find($ids);
        return view('pages.pegawai.project.laporan',compact('data','laporan'));
    }

    public function update(Request $request, $id)
    {
        // Validate the incoming request data
        $request->validate([
            'ringkasan' => 'nullable|string',
            'pencapaian' => 'nullable|string',
            'hasil' => 'nullable|string',
            'kendala' => 'nullable|string',
            'solusi' => 'nullable|string',
            'rencana' => 'nullable|string',
            'inisiatif_tambahan' => 'nullable|string',
            'catatan' => 'nullable|string',
        ]);

        // Find the LaporanM instance by ID
        $laporan = LaporanM::findOrFail($id);

        // Update the model's attributes
        $laporan->ringkasan = $request->input('ringkasan');
        $laporan->pencapaian = $request->input('pencapaian');
        $laporan->hasil = $request->input('hasil');
        $laporan->kendala = $request->input('kendala');
        $laporan->solusi = $request->input('solusi');
        $laporan->rencana = $request->input('rencana');
        $laporan->inisiatif_tambahan = $request->input('inisiatif_tambahan');
        $laporan->catatan = $request->input('catatan');

        // Save the changes to the database
        $laporan->save();
        $idss = ProjectM::where('id',$laporan->project_id)->value('id');
        // Redirect or return a response, possibly with a success message
        return redirect()->route('pegawai.project.laporan',$idss)->with('success', 'Laporan updated successfully.');
    }

    public function detail ($id){
        $data = ProjectM::find($id);
        return view('pages.pegawai.project.detail',compact('data'));
    }

    public function kontrak_show($id){
        $data = KontrakM::find($id);
        return view('pages.hc.kelolakontrak.show',compact('data'));
    }
}
