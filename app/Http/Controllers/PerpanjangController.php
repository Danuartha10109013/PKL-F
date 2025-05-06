<?php

namespace App\Http\Controllers;

use App\Models\HistoryPerpanjanganM;
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
// Menentukan total nilai rata-rata per pegawai
$penilaianGrouped = $penilaian->groupBy('user_id')->map(function ($items) {
    // Menghitung rata-rata nilai total per pegawai
    $totalScore = $items->avg(function ($item) {
        return ($item->total);
    });
    return $totalScore;
});
if ($penilaianGrouped->filter()->isEmpty()) {
    return redirect()->back()->with('error', 'Belum Ada Penilaian');
}

// dd($penilaianGrouped);
// Menghitung skor kontrak dan proyek untuk setiap pegawai
$results = $penilaian->map(function ($item) use ($penilaianGrouped, $kontrak, $proyek) {
    // Skor kontrak berdasarkan periode terbaru
    $kontrakUser = $kontrak->where('user_id', $item->user_id)->sortByDesc('periode')->first();
    $kontrakScore = $kontrakUser ? (int) $kontrakUser->periode : 0;
    
    // Menghitung total proyek yang diikuti oleh pegawai
    $projectInvolvement = ProjectM::whereJsonContains('pegawai_id', $item->user_id)->get(); 
    $projectScore = $projectInvolvement->count() > 0 ? log($projectInvolvement->count() + 1) : 0;
    
    // Ambil nilai total berdasarkan rata-rata untuk pegawai ini
    $totalScore = $penilaianGrouped[$item->user_id] ?? 0;
    
    // Normalisasi nilai total
    $normalizedTotal = $totalScore / max($penilaianGrouped->values()->toArray()) ;

    // Bobot untuk setiap parameter
    $weights = [
        'total' => 0.6,  // Bobot untuk total nilai
        'kontrak' => 0.2,
        'project' => 0.2,
    ];
    // dd($penilaianGrouped);
    
    // Perhitungan SAW (Simple Additive Weighting)
    $total = (
        $normalizedTotal * $weights['total'] +
        $kontrakScore * $weights['kontrak'] +
        $projectScore * $weights['project']
    );
    // dd($total);
    // Hasil akhir untuk setiap pegawai
    return [
        'user_id' => $item->user_id,
        'total' => $total,
        'periode' => $kontrakScore,
        'projects' => $projectInvolvement->pluck('judul'),
    ];
});
// dd($results);
$uniqueResults = collect($results)->groupBy('user_id')->map(function ($group) {
    // If it's an array, ensure you're treating it as an array and access elements with array notation
    $firstItem = $group[0]; 
    $projects = $group->pluck('projects')->flatten()->unique();// Get the first item from the group (array)
    return [
        'user_id' => $firstItem['user_id'], // Access 'user_id' directly as array
        'total' => collect($group)->sum('total'), // Sum the 'total' for the same user_id
        'periode' => $firstItem['periode'],
        'projects' => $projects,
    ];
});

// dd($uniqueResults);

$sortedResults = $uniqueResults->sortByDesc('total');


// Menyimpan data dalam varabel $data
$data = $sortedResults->map(function ($item) {
    $user = User::find($item['user_id']);
    return [
        'user' => $user,
        'total' => $item['total'],
        'periode' => $item['periode'],
        'projects' => $item['projects'],
    ];
});
// dd($data);

        
        return view('pages.manajerhc.perpnajang.index', compact('data'));
    }
    


}
