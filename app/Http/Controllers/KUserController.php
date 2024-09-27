<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class KUserController extends Controller
{
    public function index(){
        $lastUser = User::orderBy('no_pegawai', 'desc')->first();

        if ($lastUser && preg_match('/^EMP(\d+)$/', $lastUser->no_pegawai, $matches)) {
            // Increment the number
            $newNoPegawai = 'EMP' . str_pad($matches[1] + 1, 3, '0', STR_PAD_LEFT);
        } else {
            // If no users exist, start with EMP001
            $newNoPegawai = 'EMP001';
        }

        $data = User::paginate(10);
        $count = User::where('role', '!=', 4)->count();
        $countpegawai = User::where('role',1)->count();
        $counthc = User::where('role',0)->count();
        $countmanajerhc = User::where('role',3)->count();
        $countkapro = User::where('role',2)->count();
        return view('pages.hc.kelolauser.index',compact('data','count','countpegawai','counthc','countmanajerhc','countkapro','newNoPegawai'));
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
            'role' => 'required|integer',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Validating image file
            'status' => 'required|boolean',
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
        $user->password = Hash::make($request->password);
        $user->role = $request->role;
        $user->active = $request->status;
        $user->profile = $avatarPath; // Save the avatar path if uploaded
        $user->email_verified_at = now();
        $user->save();

        return redirect()->route('hc.kelola-user')->with('success', 'User created successfully');
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
        'username' => 'required|string|max:255|unique:users,username,' . $user->id,
        'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        'password' => 'nullable|string|min:6|confirmed', // Optional password, 'confirmed' rule for password confirmation
        'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    // Update user fields
    $user->name = $request->name;
    $user->username = $request->username;
    $user->email = $request->email;

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

}
