<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index($id){
        $data = User::find($id);
        return view('pages.profile.index',compact('data'));
    }


    public function update(Request $request)
{
    // Validate input fields
    $request->validate([
        'user_id' => 'required',
        'name' => 'required|string|max:255',
        'username' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'profile' => 'nullable|file|image|max:2048', // For avatar update
        'posisi' => 'nullable|string|max:255',
        'gender' => 'nullable|string|max:255',
        'tempat_lahir' => 'nullable|string|max:255',
        'tanggal_lahir' => 'nullable|date',
        'phone' => 'nullable|string|max:15',
        'no_ktp' => 'nullable|string|max:50',
        'alamat' => 'nullable|string|max:255',
        'rt' => 'nullable|string|max:5',
        'rw' => 'nullable|string|max:5',
        'kelurahan' => 'nullable|string|max:255',
        'kecamatan' => 'nullable|string|max:255',
        'kota' => 'nullable|string|max:255',
        'provinsi' => 'nullable|string|max:255',
        'kode_pos' => 'nullable|string|max:10',
        'agama' => 'nullable|string|max:255',
        'kawin' => 'nullable|string|max:255',
        'personel_number' => 'nullable|string|max:255',
        'tanggungan' => 'nullable|integer',
        'npwp' => 'nullable|string|max:20',
        'no_bpjs' => 'nullable|string|max:20',
        'no_bpjstk' => 'nullable|string|max:20',
        'terdaftar_bpjstk' => 'nullable|string|max:20',
        'lokasi_bpjs' => 'nullable|string|max:20',
        'password' => 'nullable|string|min:8|confirmed', // Optional if password is changed
    ]);

    // Fetch the current user
    $user = User::findOrFail($request->user_id);

    // Update basic profile information
    $user->username = $request->username;
    $user->name = $request->name;
    $user->email = $request->email;

    // Update optional fields
    $user->posisi = $request->posisi;
    $user->personel_number = $request->personel_number;
    $user->gender = $request->gender;
    $user->tempat_lahir = $request->tempat_lahir;
    $user->tanggal_lahir = $request->tanggal_lahir;
    $user->phone = $request->phone;
    $user->no_ktp = $request->no_ktp;
    $user->alamat = $request->alamat;
    $user->rt = $request->rt;
    $user->rw = $request->rw;
    $user->kelurahan = $request->kelurahan;
    $user->kecamatan = $request->kecamatan;
    $user->kota = $request->kota;
    $user->provinsi = $request->provinsi;
    $user->kode_pos = $request->kode_pos;
    $user->agama = $request->agama;
    $user->kawin = $request->kawin;
    $user->tanggungan = $request->tanggungan;
    $user->npwp = $request->npwp;
    $user->no_bpjs = $request->no_bpjs;
    $user->no_bpjstk = $request->no_bpjstk;
    $user->lokasi_bpjs = $request->lokasi_bpjs;
    $user->terdaftar_bpjstk = $request->terdaftar_bpjstk;

    // Update password if provided
    if ($request->password) {
        $user->password = Hash::make($request->password);
    }

    // Update profile picture if provided
    if ($request->hasFile('profile')) {
        // Delete the old profile picture if it exists
        if ($user->profile) {
            Storage::disk('public')->delete($user->profile);
        }

        // Store the new profile picture
        $avatarPath = $request->file('profile')->store('avatars', 'public');
        $user->profile = $avatarPath;
    }

    // Save the changes to the user
    $user->save();

    // Redirect back with success message
    return redirect()->route('profile', $user->id)
                     ->with('success', 'Account updated successfully');
}

    

}

