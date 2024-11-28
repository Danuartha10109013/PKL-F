<?php

namespace App\Http\Controllers;

use App\Models\KontrakM;
use App\Models\User;
use Illuminate\Http\Request;

class KKontrakController extends Controller
{
    public function index(Request $request)
    {
        // Retrieve search input
        $search = $request->input('search');
        if($search){
            // Fetch user IDs matching the search term
            $userIds = User::when($search, function ($query, $search) {
                return $query->where('name', 'like', '%' . $search . '%')->pluck('id');
            });
    
            // Fetch contracts associated with the user IDs
            $data = KontrakM::when($userIds->isNotEmpty(), function ($query) use ($userIds) {
                return $query->whereIn('user_id', $userIds);
            })->paginate(10);
        }else{
            $data = KontrakM::orderBy('created_at','desc')->paginate(10);
        }

        return view('pages.hc.kelolakontrak.index', compact('data', 'search'));
    }


}
