<?php

namespace App\Http\Controllers;

use App\Models\ProjectM;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KProjectController extends Controller
{
    public function index(Request $request){
        //search
        $search = $request->input('search');

        // Modify the query to include search functionality
        $hasil = ProjectM::when($search, function ($query, $search) {
            return $query->where('judul', 'like', '%' . $search . '%')  
                        ->orWhere('subjudul', 'like', '%' . $search . '%')  
                        ->orWhere('deskripsi', 'like', '%' . $search . '%'); 
        })->paginate(10);


        $datakapro = User::where('role', 2)->get();

        $same = ProjectM::value('id');
        $Kapro = User::where('project_id', $same)->value('name');

        if(Auth::user()->role == 2) {
            $data = ProjectM::where('project_id', $hasil)->paginate(10);
            // $data = User::paginate(10);
        }else{
            $data = ProjectM::paginate(10);
        }
        $count = ProjectM::all()->count();
        $countpegawai = ProjectM::where('status',0)->count();
        $counthc = ProjectM::where('status',1)->count();
        $countkapro = ProjectM::where('status',2)->count();
        if(Auth::user()->role == 0){
            return view('pages.hc.kelolaproject.index',compact('data','count','countpegawai','counthc','countkapro','hasil','datakapro','Kapro'));
        }else{
            return view('pages.kapro.kelolauser.index',compact('data','count','countpegawai','counthc','countkapro','hasil','datakapro','Kapro'));
        }
    }

    public function store(Request $request)
    {
        // dd($request->all());
        // Validate the incoming request data
        $request->validate([
            'judul' => 'required|string|max:255',
            'kode_project' => 'required|string|unique:project',
            'deskripsi' => 'nullable|string',
            'kode_uk' => 'required|string',
            'divisi' => 'required|string',
            'unit_kerja' => 'required|string',
            'gaji' => 'required|integer',
            'start' => 'required|date',
            'end' => 'required|date',
            'kapro' => 'required',
        ]);

        // Create a new user (or any related model) using the validated data
        $project = new ProjectM();
        $project->judul = $request->input('judul');
        $project->kode_project = $request->input('kode_project', null);
        $project->deskripsi = $request->input('deskripsi', null);
        $project->divisi = $request->input('divisi');
        $project->kode_uk = $request->input('kode_uk');
        $project->unit_kerja = $request->input('unit_kerja');
        $project->gaji = $request->input('gaji');
        $project->start = $request->input('start');
        $project->end = $request->input('end');
        $project->status = 0; //inactive
        $project->kapro_id = $request->input('kapro'); //inactive
        $project->save();

        

        // Optionally, you can return a response or redirect to a success page
        return redirect()->route('hc.kelola-project')->with('success', 'Project created successfully!');
    }

    public function delete($id)
{
    $item = ProjectM::find($id);

    if ($item) {
        $item->delete();
        $users = User::where('project_id', $id)->get();

        // Loop through each user and set the project_id to null
        foreach ($users as $user) {
            $user->project_id = null;
            $user->save(); // Use save() to persist the changes
        }
    return redirect()->back()->with('success', 'Item deleted successfully.');
    }

    return redirect()->back()->with('error', 'Item not found.');
}

public function update(Request $request, $id)
{
    // Validate the incoming request data
    $request->validate([
        'judul' => 'required|string|max:255',
        'kode_project' => 'required',
        'deskripsi' => 'nullable|string',
        'kode_uk' => 'required|string',
        'divisi' => 'required|string',
        'unit_kerja' => 'required|string',
        'gaji' => 'required|integer',
        'start' => 'required|date',
        'end' => 'required|date',
        'kapro' => 'required', // Ensure the selected ketua project exists in the users table
    ]);

    // Find the project by ID
    $project = ProjectM::findOrFail($id);

    // Update the project with the validated data
    $project->judul = $request->judul;
    $project->kode_project = $request->kode_project;
    $project->deskripsi = $request->deskripsi;
    $project->kode_uk = $request->kode_uk;
    $project->unit_kerja = $request->unit_kerja;
    $project->divisi = $request->divisi;
    $project->start = $request->start;
    $project->end = $request->end;
    $project->gaji = $request->gaji;
    $project->kapro_id = $request->kapro;
    
    // Save the changes to the database
    $project->save();

    // Redirect back with a success message
    return redirect()->back()->with('success', 'Project updated successfully.');
}
}
