<?php

namespace App\Http\Controllers;

use App\Models\KontrakM;
use App\Models\LaporanM;
use App\Models\PenilaianM;
use App\Models\ProjectM;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function index(){
        $hasil = [];
        $data = ProjectM::where('kapro_id', Auth::user()->id)->paginate(10);
        return view('pages.kapro.project.index',compact('data','hasil'));
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


        // dd($cc);
        // $user_terlibat = User::where('id',$same)->get()
        return view('pages.kapro.project.detail',compact('data','users','cc','newNoPegawai'));
    }

    public function addUser(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'user_id' => 'required|exists:users,id', // Ensure the user exists
        ]);

        // Find the project by ID
        $project = ProjectM::findOrFail($request->project_id);

        // Retrieve the existing pegawai_id and decode it
        $pegawai_ids = json_decode($project->pegawai_id, true);

        // If pegawai_id is not an array, initialize it
        if (!is_array($pegawai_ids)) {
            $pegawai_ids = [];
        }

        // Add the new user ID if it's not already present
        if (!in_array($request->user_id, $pegawai_ids)) {
            $pegawai_ids[] = $request->user_id;

            // Update the project with the new pegawai_id
            $project->pegawai_id = json_encode($pegawai_ids);
            $project->save();

            return redirect()->back()->with('success', 'User added successfully.');
        }

        return redirect()->back()->with('error', 'User is already assigned to this project.');
    }

    public function activate(Request $request,$id)
    {
        $data = ProjectM::find($id);
    
        $data->status = $request->status;
        $data->save();
    
        $pegawaiList = json_decode($data->pegawai_id, true); 
        if (is_array($pegawaiList) && !empty($pegawaiList)) {
            foreach ($pegawaiList as $pegawaiId) {
                $user = User::find($pegawaiId); 
            
                // if ($user) {
                //     $periode = KontrakM::where('user_id',$pegawaiId)->count();
            
                //     $kontrak = new KontrakM();
                //     $kontrak->user_id = $pegawaiId; 
                //     $kontrak->awal_kontrak = $data->start;
                //     $kontrak->akhir_kontrak = $data->end;
                //     $kontrak->periode = $periode + 1;
                //     $kontrak->project_id = $id;
                //     $kontrak->save(); 
                // }
            }
            
        } else {
            return response()->json(['error' => 'Pegawai list is empty or invalid'], 400);
        }
        return redirect()->back()->with('success','Project telah dimulai');
    }
    

    public function complete($id){
        $data = ProjectM::find($id);
        $data->status = 2;
        $data->save();

        $laporankapro = new LaporanM();
        $laporankapro->project_id = $data->id;
        $laporankapro->user_id = $data->kapro_id;
        $laporankapro->save();

        return redirect()->back()->with('success','Project telah selesai');

    }

    public function delete_user($id,$pid)
    {
        // dd($pid,$id);
        $user = \App\Models\User::findOrFail($id);

        $projects = \App\Models\ProjectM::where('id',$pid)->whereJsonContains('pegawai_id', (string)$id)->get();
        // dd($projects);
        foreach ($projects as $project) {
            $pegawaiIds = json_decode($project->pegawai_id, true) ?? [];

            if (is_array($pegawaiIds) && in_array((string)$id, $pegawaiIds)) {
                $pegawaiIds = array_filter($pegawaiIds, fn($value) => $value != (string)$id);

                $project->pegawai_id = json_encode(array_values($pegawaiIds));
                $project->save();
            }
        }

        PenilaianM::where('user_id', $id)->where('project_id',$pid)->delete();
        LaporanM::where('user_id', $id)->where('project_id',$pid)->delete();


        return redirect()->back()->with('success', 'User deleted successfully, and they have been removed from all related projects.');
    }

    public function nilaiUser(Request $request, $id,$pid,$m)
    {
        $request->validate([
            'project_id' => 'required|string|max:255',
            'hasil_kerja' => 'required|numeric|min:0|max:100',
            'kualitas_kerja' => 'required|numeric|min:0|max:100',
            'kepatuhan_sop' => 'required|numeric|min:0|max:100',
        ]);
        // dd($request->all());
        $user = User::findOrFail($id);
    
        $hasilKerjaScore = $request->input('hasil_kerja') * 0.35; 
        $kualitasKerjaScore = $request->input('kualitas_kerja') * 0.40; 
        $kepatuhanSOPScore = $request->input('kepatuhan_sop') * 0.25; 
        $totalScore = $hasilKerjaScore + $kualitasKerjaScore + $kepatuhanSOPScore;
        $code = PenilaianM::where('user_id',$id)->where('project_id',$pid)->where('created_at',$m)->value('id');
        $data = PenilaianM::find($code);
        // dd($code);
        $data->hasil_kerja = $request->hasil_kerja;
        $data->kualitas_kerja = $request->kualitas_kerja;
        $data->kepatuhan_sop = $request->kepatuhan_sop;
        $data->total = $totalScore;
        $data->keterangan = $request->keterangan;
        $data->save();
    
        return redirect()->back()->with('success', 'Nilai berhasil diberikan untuk ' . $user->name);
    }
    
    public function isilaporan($id){
        $data = ProjectM::find($id);
        $ids = LaporanM::where('user_id',$data->kapro_id)->where('project_id',$id)->value('id');
        $laporan= LaporanM::find($ids);
        // dd($laporan);
        return view('pages.kapro.project.laporankapro',compact('data','laporan'));
    }

    public function isiupdate(Request $request, $id)
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
        // Redirect or return a response, possibly with a success message
        return redirect()->route('kapro.project')->with('success', 'Laporan updated successfully.');
    }

    public function print($id){
        $data = ProjectM::find($id);
        return view('pages.manajerhc.project.print',compact('data'));
    }
    
}
