<?php

namespace App\Http\Controllers;

use App\Models\KontrakM;
use App\Models\LaporanM;
use App\Models\PenilaianM;
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
        $laporan = LaporanM::find($id);
        $data = ProjectM::find($laporan->project_id);
        // dd($ids);
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
        $curentMonth = now()->format('m');
        $curentYear = now()->format('Y');

        // Cek apakah ada data penilaian untuk project ini
        $cekPenilaian = PenilaianM::where('project_id', $id)->whereMonth('created_at',$curentMonth)->whereYear('created_at',$curentYear)->count();

        $curentMonth = now()->format('m');
        $curentYear = now()->format('Y');

        // Cek apakah ada data penilaian untuk project ini
        $cekPenilaian = PenilaianM::where('project_id', $id)
            ->whereMonth('created_at', $curentMonth)
            ->whereYear('created_at', $curentYear)
            ->count();
        $cekPegawai = PenilaianM::where('user_id', $data->pegawai_id)->value('id');

        if ($cekPenilaian == 0 && $data->pegawai_id !== null) {
            // Decode pegawai_id dari JSON
            $user_ids = json_decode($data->pegawai_id, true); // pastikan $data diambil dari model ProjectM misalnya

            foreach ($user_ids as $uid) {
                $baru = new PenilaianM();
                $baru->user_id = $uid;
                $baru->project_id = $id;
                $baru->save();

                $lap = new LaporanM();
                $lap->user_id = $uid;
                $lap->project_id = $id;
                $lap->save();
            }
        } else {
            $user_ids = json_decode($data->pegawai_id, true); // pastikan $data diambil dari model ProjectM misalnya
            // dd($user_ids);
            // Cek apakah sudah ada data penilaian dengan user_id pada bulan ini
            foreach ($user_ids as $u) {
                // Cek apakah user_id $u sudah ada pada Penilaian untuk project_id, bulan dan tahun yang sama
                $cekUserPenilaian = PenilaianM::where('project_id', $id)
                    ->whereMonth('created_at', $curentMonth)
                    ->whereYear('created_at', $curentYear)
                    ->where('user_id', $u)
                    ->first();  // Use first() to check if any record exists for this user_id
            
                if (!$cekUserPenilaian) {
                    // Jika tidak ada, berarti user_id ini belum ada pada Penilaian, jadi simpan atau lanjutkan logika
                    $baru = new PenilaianM();
                        $baru->user_id = $u;
                        $baru->project_id = $id;
                        $baru->save();
            
                        $lap = new LaporanM();
                        $lap->user_id = $u;
                        $lap->project_id = $id;
                        $lap->save();
                }
            }
            
        }

        return view('pages.pegawai.project.detail',compact('data'));
    }

    public function kontrak_show($id){
        $data = KontrakM::find($id);
        return view('pages.hc.kelolakontrak.show',compact('data'));
    }
}
