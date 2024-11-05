<?php

namespace App\Http\Controllers;

use App\Models\KontrakM;
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

    public function activate($id)
    {
        // Find the project by its ID
        $data = ProjectM::find($id);
    
        // Update the project status to 'active'
        $data->status = 1;
        $data->save();
    
        // Decode pegawai_id since it's a JSON string (e.g., ["2", "7", "14"])
        $pegawaiList = json_decode($data->pegawai_id, true); // true to convert to an associative array
        // dd($pegawaiList);
        // Ensure we have a valid array before looping
        if (is_array($pegawaiList) && !empty($pegawaiList)) {
            // Loop through each employee in the list
            foreach ($pegawaiList as $pegawaiId) {
                // Find the user by their ID
                $user = User::find($pegawaiId); // Use 'find' since you only need one record
            
                if ($user) {
                    // Try to find an existing contract for the user
                    $periode = KontrakM::where('user_id',$pegawaiId)->count();
                    // If no existing contract, start with periode = 1
                    // Otherwise, increment the existing contract's periode
                    // $periode = $kontrakin ? $kontrakin->periode + 1 : 1;
                    // dd($pegawaiId);
            
                    // Create a new contract for the user
                    $kontrak = new KontrakM();
                    $kontrak->user_id = $pegawaiId; // Assign the employee ID
                    $kontrak->awal_kontrak = $data->start;
                    $kontrak->akhir_kontrak = $data->end;
                    $kontrak->periode = $periode + 1;
                    $kontrak->project_id = $id;
                    $kontrak->save(); // Save the contract to the database
                }
            }
            
        } else {
            // Handle the case where pegawai_id is null, invalid, or empty
            return response()->json(['error' => 'Pegawai list is empty or invalid'], 400);
        }
        return redirect()->back()->with('success','Project telah dimulai, Kontrak terbuat');
    }
    

    public function complete($id){
        $data = ProjectM::find($id);
        // dd($data);
        $data->status = 2;
        $data->save();
        return redirect()->back()->with('success','Project telah selesai');

    }

    // UserController.php
    public function delete_user($id)
    {
        // Find the user by ID
        $user = \App\Models\User::findOrFail($id);

        $projects = \App\Models\ProjectM::whereJsonContains('pegawai_id', (string)$id)->get();

        foreach ($projects as $project) {
            $pegawaiIds = json_decode($project->pegawai_id, true) ?? [];

            if (is_array($pegawaiIds) && in_array((string)$id, $pegawaiIds)) {
                $pegawaiIds = array_filter($pegawaiIds, fn($value) => $value != (string)$id);

                $project->pegawai_id = json_encode(array_values($pegawaiIds));
                $project->save();
            }
        }

        return redirect()->back()->with('success', 'User deleted successfully, and they have been removed from all related projects.');
    }

    public function nilaiUser(Request $request, $id)
    {
        // Validate the incoming scores
        $request->validate([
            'project_id' => 'required|string|max:255',
            'hasil_kerja' => 'required|numeric|min:0|max:100',
            'kualitas_kerja' => 'required|numeric|min:0|max:100',
            'kepatuhan_sop' => 'required|numeric|min:0|max:100',
        ]);
    
        // Retrieve the user by ID
        $user = User::findOrFail($id);
    
        // Calculate the weighted score
        $hasilKerjaScore = $request->input('hasil_kerja') * 0.35; // 35% weight
        $kualitasKerjaScore = $request->input('kualitas_kerja') * 0.40; // 40% weight
        $kepatuhanSOPScore = $request->input('kepatuhan_sop') * 0.25; // 25% weight
    
        // Total weighted score
        $totalScore = $hasilKerjaScore + $kualitasKerjaScore + $kepatuhanSOPScore;
    
        // Save the score or update it in the database (you can store it in a new model or table)
        // Assuming there's a 'user_scores' table with a 'score' column
        $data = new PenilaianM();
        $data->user_id = $request->input('user_id');
        $data->project_id = $request->input('project_id');
        $data->hasil_kerja = $request->input('hasil_kerja');
        $data->kualitas_kerja = $request->input('kualitas_kerja');
        $data->kepatuhan_sop = $request->input('kepatuhan_sop');
        $data->total = $totalScore;
        $data->keterangan = $request->input('keterangan');
        $data->save();
    
        // Redirect back with success message
        return redirect()->back()->with('success', 'Nilai berhasil diberikan untuk ' . $user->name);
    }
    

    
}
