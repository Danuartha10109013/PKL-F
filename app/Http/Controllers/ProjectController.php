<?php

namespace App\Http\Controllers;

use App\Models\KontrakM;
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
        // $user_terlibat = User::where('id',$same)->get()
        return view('pages.kapro.project.detail',compact('data','users'));
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

    public function activate($id){
        $data = ProjectM::find($id);

        $data->status = 1;
        $data->save();

        $periode = $data->pegawai_id;
        $list = $data->pegawai_id;

        foreach ($list as $l){
            $user = User::where('id',$l)->get();
        }

        $kontrak = new KontrakM();
        $kontrak->user_id = $list;
        $kontrak->awal_kontrak = $data->start;
        $kontrak->akhir_kontrak = $data->end;
        $kontrak->periode = $periode;
    }
    
}
