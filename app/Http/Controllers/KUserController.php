<?php

namespace App\Http\Controllers;

use App\Events\NotifEvent;
use App\Exports\UserExportExcel;
use App\Models\HistoryPerpanjanganM;
use App\Models\KontrakM;
use App\Models\LaporanM;
use App\Models\NotifM;
use App\Models\ProjectM;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Events\NotifikasiBaru;
use Illuminate\Support\Facades\Http;

class KUserController extends Controller
{
    public function index(Request $request)
{
    // Search
    $search = $request->input('search');

    // Search functionality
    $hasil = User::where('deleteing', 0) // Pastikan deleteing = 0 dulu
    ->when($search, function ($query, $search) {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', '%' . $search . '%')
              ->orWhere('email', 'like', '%' . $search . '%')
              ->orWhere('no_pegawai', 'like', '%' . $search . '%');
        });
    })
    ->paginate(10);


    // Generate the next employee number
    $lastUser = User::orderBy('no_pegawai', 'desc')->first();
    if ($lastUser && preg_match('/^EMP(\d+)$/', $lastUser->no_pegawai, $matches)) {
        $newNoPegawai = 'EMP' . str_pad($matches[1] + 1, 3, '0', STR_PAD_LEFT);
    } else {
        $newNoPegawai = 'EMP001';
    }

    // dd($hasil);

    // Data based on role
    if (Auth::user()->role == 2) {
        $data = User::where('project_id', $newNoPegawai)->whereNot('deleteing', 1)->paginate(10);
    } else {
        $data = User::whereNot('deleteing', 1)->paginate(10);
    }

    // Count various roles
    $count = User::whereNot('deleteing', 1)->count();
    $countpegawai = User::whereNot('deleteing', 1)->where('role', 1)->count();
    $counthc = User::whereNot('deleteing', 1)->where('role', 0)->count();
    $countmhc = User::whereNot('deleteing', 1)->where('role', 3)->count();
    $countkapro = User::whereNot('deleteing', 1)->where('role', 2)->count();
    $countpusat = User::whereNot('deleteing', 1)->where('role', 4)->count();

    // View rendering
    if (Auth::user()->role == 0) {
        return view('pages.hc.kelolauser.index', compact('data', 'count', 'countpegawai', 'counthc', 'countmhc', 'countkapro', 'newNoPegawai', 'hasil', 'countpusat'));
    } else {
        return view('pages.kapro.kelolauser.index', compact('data', 'count', 'countpegawai', 'counthc', 'countmhc', 'countkapro', 'newNoPegawai', 'hasil', 'countpusat'));
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
        $user->deleteing = 0;
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

        $periode = KontrakM::where('user_id',$user->id)->count();
        $kontrak = new KontrakM();
        $kontrak->user_id = $user->id; 
        $kontrak->awal_kontrak = $request->awal;
        $kontrak->akhir_kontrak = $request->akhir;
        $kontrak->periode = $periode + 1;
        $kontrak->save(); 
        
        // dd($kontrak);
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
        $item->active = 0;
        $item->deleteing = 1;
        $item->save();
        return redirect()->back()->with('success', 'Item deleted successfully.');
    }

    return redirect()->back()->with('error', 'Item not found.');
}

public function perpanjang(Request $request,$id){
    // dd($request->all());
    $data = KontrakM::find($id);
    $data->awal_kontrak = $request->start_date;
    $data->akhir_kontrak = $request->end_date;
    $data->periode = $data->periode + 1;
    $data->save();

    $history = new HistoryPerpanjanganM();
    $history->user_id = $data->user_id;
    $history->jumlah_perpanjangan = $data->periode + 1;
    $history->awal = $request->start_date;
    $history->akhir = $request->end_date;
    $history->tanggal_perpanjangan = now()->format('Y-m-d');
    $history->save();

    $notif = NotifM::create([
        'title' => "Perpanjangan Kontrak",
        'value' => "Selamat, kontrak kamu telah diperpanjang sampai dengan " . $data->akhir_kontrak,
        'status' => 0,
        'user_id' => $data->user_id,
    ]);

    // Kirim notifikasi via broadcast
    // event(new \App\Events\NotifikasiBaru($notif));

    NotifEvent::dispatch($notif);
    

    

    

    return redirect()->back()->with('success', 'Kontrak telah diperpanjang');
}

public function export(){
    $date = now()->format('d-m-Y'); 
    return Excel::download(new UserExportExcel, $date . '_Data_Pegawai.xlsx');
}



}
