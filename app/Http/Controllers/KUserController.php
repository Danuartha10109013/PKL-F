<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class KUserController extends Controller
{
    public function index(Request $request){
        //search
        $search = $request->input('search');

        // Modify the query to include search functionality
        $hasil = User::when($search, function ($query, $search) {
            return $query->where('name', 'like', '%' . $search . '%')  
                        ->orWhere('email', 'like', '%' . $search . '%')  
                        ->orWhere('no_pegawai', 'like', '%' . $search . '%'); 
        })->paginate(10);

        $lastUser = User::orderBy('no_pegawai', 'desc')->first();

        if ($lastUser && preg_match('/^EMP(\d+)$/', $lastUser->no_pegawai, $matches)) {
            // Increment the number
            $newNoPegawai = 'EMP' . str_pad($matches[1] + 1, 3, '0', STR_PAD_LEFT);
        } else {
            // If no users exist, start with EMP001
            $newNoPegawai = 'EMP001';
        }
        if(Auth::user()->role == 2) {
            $data = User::where('project_id', $newNoPegawai)->paginate(10);
            // $data = User::paginate(10);
        }else{
            $data = User::paginate(10);
        }
        $count = User::all()->count();
        $countpegawai = User::where('role',1)->count();
        $counthc = User::where('role',0)->count();
        $countmhc = User::where('role',3)->count();
        $countkapro = User::where('role',2)->count();
        $countpusat = User::where('role',4)->count();
        if(Auth::user()->role == 0){
            return view('pages.hc.kelolauser.index',compact('data','count','countpegawai','counthc','countmhc','countkapro','newNoPegawai','hasil','countpusat'));
        }else{
            return view('pages.kapro.kelolauser.index',compact('data','count','countpegawai','counthc','countmhc','countkapro','newNoPegawai','hasil','countpusat'));
        }
    }

    public function store(Request $request)
    {
        // dd($request->all());
        // Validate form data
        $validated = $request->validate([
            'no_pegawai' => 'required|string|max:10',
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Validating image file
            'status' => 'required|boolean',
            'posisi' => 'required',
        ]);

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
        } else {
            $avatarPath = null;
        }

        // Create the user
        $user = new User();
        $user->no_pegawai = $request->no_pegawai;
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->posisi = $request->posisi;
        $user->password = Hash::make($request->password);
        if (Auth::user()->role == 0){
            $user->role = $request->role;
        }else{
            $user->role = 1;
        }
        $user->active = $request->status;
        $user->posisi = $request->posisi;
        $user->profile = $avatarPath; // Save the avatar path if uploaded
        $user->email_verified_at = now();
        $user->save();
        if (Auth::user()->role == 0){
            return redirect()->back()->with('success', 'User created successfully');
        }else{
            return redirect()->back()->with('success', 'User created successfully. Please Chose User Again');
        }
    }

    public function active($id){
        $data= User::find($id);
        $data->active = 1;
        $data->save();

        return redirect()->back()->with('success', 'User is Active now');
    }
    public function nonactive($id){
        $data= User::find($id);
        $data->active = 0;
        $data->save();

        return redirect()->back()->with('success', 'User is Nonactive now');
    }

    public function update(Request $request, $id)
{
    // Find the user by ID
    $user = User::findOrFail($id);

    // Validate the input
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'posisi' => 'required|string|max:255',
        'username' => 'required|string|max:255|unique:users,username,' . $user->id,
        'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        'password' => 'nullable|string|min:6|confirmed', // Optional password, 'confirmed' rule for password confirmation
        'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    // Update user fields
    $user->name = $request->name;
    $user->username = $request->username;
    $user->email = $request->email;
    $user->posisi = $request->posisi;

    // If a new password is provided, hash it and update
    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
    }

    // Handle avatar upload (if present)
    if ($request->hasFile('avatar')) {
        $avatarPath = $request->file('avatar')->store('avatars', 'public');
        $user->profile = $avatarPath;
    }

    // Save the updated user
    $user->save();

    return redirect()->back()->with('success', 'User updated successfully');
}

public function delete($id)
{
    $item = User::find($id);

    if ($item) {
        $item->delete();
        return redirect()->back()->with('success', 'Item deleted successfully.');
    }

    return redirect()->back()->with('error', 'Item not found.');
}


}
