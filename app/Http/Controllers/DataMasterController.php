<?php

namespace App\Http\Controllers;

use App\Models\DepartementM;
use App\Models\KategoriM;
use App\Models\StatusM;
use App\Models\StrategicM;
use Illuminate\Http\Request;

class DataMasterController extends Controller
{
    public function index(){
        $kategori = KategoriM::all();
        $status = StatusM::all();
        $departement = DepartementM::all();
        $strategic = StrategicM::all();

        return view('pages.hc.data.index', compact('kategori','status','departement','strategic'));
    }

    public function store(Request $request, $type)
    {
        if($type == 'kategori'){
            KategoriM::create([
                'kategori' => $request->value,
            ]);

        }elseif($type == 'status'){
            StatusM::create([
                'status' => $request->value,
            ]);
        }elseif($type == 'strategic'){
            StrategicM::create([
                'strategic' => $request->value,
            ]);
        }elseif($type == 'departement'){
            DepartementM::create([
                'departement' => $request->value,
            ]);
        }else {
            return back()->with('error', 'Tipe tidak dikenali.');
        }

        return back()->with('success', ucfirst($type) . ' berhasil ditambahkan.');
    }

    public function edit(Request $request, $id)
    {
        // dd($request->tipe);
        

        if($request->tipe == 'kategori'){
            $data = KategoriM::find($id);
            $data->kategori = $request->kategori;
            $data->save();
        }elseif($request->tipe == 'status'){
            $data = StatusM::find($id);
            $data->status = $request->status;
            $data->save();
        }elseif($request->tipe == 'strategic'){
            $data = StrategicM::find($id);
            $data->strategic = $request->strategic;
            $data->save();
        }elseif($request->tipe == 'departement'){
            $data = DepartementM::find($id);
            $data->departement = $request->departement;
            $data->save();
        }else {
            return back()->with('error', 'Tipe tidak dikenali.');
        }

       

        return back()->with('success', ucfirst($request->tipe) . ' berhasil diperbarui.');
    }

    public function delete(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            'tipe' => 'required|string',
        ]);

        if($request->tipe == 'kategori'){
            $data = KategoriM::find($id);
            $data->delete();
        }elseif($request->tipe == 'status'){
            $data = StatusM::find($id);
            $data->delete();
        }elseif($request->tipe == 'strategic'){
            $data = StrategicM::find($id);
            $data->delete();
        }elseif($request->tipe == 'departement'){
            $data = DepartementM::find($id);
            $data->delete();
        }else {
            return back()->with('error', 'Tipe tidak dikenali.');
        }

        

        return back()->with('success', ucfirst($request->tipe) . ' berhasil dihapus.');
    }
}
