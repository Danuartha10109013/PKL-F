<?php

namespace App\Http\Controllers;

use App\Models\KontrakM;
use App\Models\PenilaianM;
use App\Models\ProjectM;
use App\Models\User;
use Illuminate\Http\Request;

class PerpanjangController extends Controller
{
    public function index()
    {
        $penilaian = PenilaianM::all();
        $kontrak = KontrakM::all();
        $proyek = ProjectM::all();  // Replace this with query builder for whereJsonContains
    
        $maxValues = [
            'hasil_kerja' => $penilaian->max('hasil_kerja'),
            'kualitas_kerja' => $penilaian->max('kualitas_kerja'),
            'kepatuhan_sop' => $penilaian->max('kepatuhan_sop'),
        ];
    
        $results = $penilaian->map(function ($item) use ($maxValues, $kontrak, $proyek) {
            $kontrakUser = $kontrak->where('user_id', $item->user_id)->sortByDesc('periode')->first();
            $kontrakScore = $kontrakUser ? (int) $kontrakUser->periode : 0;
    
            // Fix: Use query builder for whereJsonContains
            $projectInvolvement = ProjectM::whereJsonContains('pegawai_id', $item->user_id)->get(); // Fetch the relevant projects
            $projectScore = $projectInvolvement->count() > 0 ? log($projectInvolvement->count() + 1) : 0;
    
            $normalized = [
                'hasil_kerja' => $item->hasil_kerja / $maxValues['hasil_kerja'],
                'kualitas_kerja' => $item->kualitas_kerja / $maxValues['kualitas_kerja'],
                'kepatuhan_sop' => $item->kepatuhan_sop / $maxValues['kepatuhan_sop'],
            ];
    
            $weights = [
                'hasil_kerja' => 0.3,
                'kualitas_kerja' => 0.3,
                'kepatuhan_sop' => 0.2,
                'kontrak' => 0.1,
                'project' => 0.1,
            ];
    
            $total = (
                $normalized['hasil_kerja'] * $weights['hasil_kerja'] +
                $normalized['kualitas_kerja'] * $weights['kualitas_kerja'] +
                $normalized['kepatuhan_sop'] * $weights['kepatuhan_sop'] +
                $kontrakScore * $weights['kontrak'] +
                $projectScore * $weights['project']
            );
    
            return [
                'user_id' => $item->user_id,
                'total' => $total,
                'periode' => $kontrakScore,
                'projects' => $projectInvolvement->pluck('judul'),
            ];
        });
    
        $uniqueResults = $results->groupBy('user_id')->map(function ($group) {
            return $group->sortByDesc('total')->first();
        });
    
        $sortedResults = $uniqueResults->sortByDesc('total');
    
        $data = $sortedResults->map(function ($item) {
            $user = User::find($item['user_id']);
            return [
                'user' => $user,
                'total' => $item['total'],
                'periode' => $item['periode'],
                'projects' => $item['projects'],
            ];
        });
    
        return view('pages.manajerhc.perpnajang.index', compact('data'));
    }
    


}
