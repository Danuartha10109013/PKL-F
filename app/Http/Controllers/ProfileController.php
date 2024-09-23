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
    ]);

    // Fetch the current user
    $user = User::find($request->user_id);

    // Update name and email
    $user->username = $request->username;
    $user->name = $request->name;
    $user->email = $request->email;

    if ($request->password != null) {
        $user->password = Hash::make($request->password); // Hash password
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

    // Save the changes
    $user->save();

    // Redirect back with success message
    return redirect()->route('pegawai.profile', $request->user_id)
                     ->with('success', 'Account updated successfully');
}

}

