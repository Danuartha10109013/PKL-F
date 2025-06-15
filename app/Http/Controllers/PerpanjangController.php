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
    // Ambil semua data penilaian, kontrak, dan proyek
    $penilaian = PenilaianM::all();
    $kontrak = KontrakM::all();
    $proyek = ProjectM::all();

    // Group penilaian berdasarkan user_id dan hitung rata-rata nilai total per user
    $penilaianGrouped = $penilaian->groupBy('user_id')->map(function ($items) {
        return $items->avg('total'); // Rata-rata nilai
    });

    // Validasi jika tidak ada penilaian
    if ($penilaianGrouped->filter()->isEmpty()) {
        return redirect()->back()->with('error', 'Belum Ada Penilaian');
    }

    // Hitung nilai maksimum dari setiap aspek untuk normalisasi
    $maxTotal = $penilaianGrouped->max() ?: 1;
    $maxKontrak = $kontrak->max('periode') ?: 1;

    // Hitung jumlah maksimum proyek yang melibatkan pegawai
    $maxProjectScore = $proyek->map(function ($proj) {
        return count(json_decode($proj->pegawai_id, true));
    })->max();
    $maxProjectLog = $maxProjectScore > 0 ? log($maxProjectScore + 1) : 1;

    // Bobot masing-masing aspek
    $weights = [
        'total' => 0.6,
        'kontrak' => 0.2,
        'project' => 0.2,
    ];

    // Validasi bobot
    if (array_sum($weights) !== 1.0) {
        return redirect()->back()->with('error', 'Total bobot tidak valid. Harus berjumlah 1.');
    }

    // Hitung skor per user
    $results = $penilaian->map(function ($item) use ($penilaianGrouped, $kontrak, $proyek, $maxTotal, $maxKontrak, $maxProjectLog, $weights) {
        // Ambil kontrak terakhir user
        $kontrakUser = $kontrak->where('user_id', $item->user_id)->sortByDesc('periode')->first();
        $kontrakScore = $kontrakUser ? (int) $kontrakUser->periode : 0;
        $normalizedKontrak = $kontrakScore / $maxKontrak;

        // Hitung keterlibatan proyek
        $projectInvolvement = $proyek->filter(function ($proj) use ($item) {
            $pegawaiIds = json_decode($proj->pegawai_id, true) ?? [];
            return in_array($item->user_id, $pegawaiIds);
        });
        $projectScore = $projectInvolvement->count() > 0 ? log($projectInvolvement->count() + 1) : 0;
        $normalizedProject = $projectScore / $maxProjectLog;

        // Ambil nilai rata-rata penilaian user
        $totalScore = $penilaianGrouped[$item->user_id] ?? 0;
        $normalizedTotal = $totalScore / $maxTotal;

        // Hitung skor akhir dan konversi ke skala 1-100
        $finalScoreRaw = (
            $normalizedTotal * $weights['total'] +
            $normalizedKontrak * $weights['kontrak'] +
            $normalizedProject * $weights['project']
        );
        $finalScore = $finalScoreRaw * 100; // Konversi ke skala 1–100

        // Kembalikan data hasil hitung
        return [
            'user_id' => $item->user_id,
            'total' => $finalScore, // Sudah skala 1–100
            'periode' => $kontrakScore,
            'projects' => $projectInvolvement->pluck('judul'),
        ];
    });

    // Gabungkan berdasarkan user_id (hindari duplikat user)
    $uniqueResults = collect($results)->groupBy('user_id')->map(function ($group) {
        $firstItem = $group->first();
        $projects = $group->pluck('projects')->flatten()->unique();

        return [
            'user_id' => $firstItem['user_id'],
            'total' => collect($group)->avg('total'), // Pakai rata-rata jika ada duplikat
            'periode' => $firstItem['periode'],
            'projects' => $projects,
        ];
    });

    // Filter user dengan skor >= 60
    $filteredResults = $uniqueResults->filter(function ($item) {
        return $item['total'] >= 0;
    });

    // Urutkan skor dari tertinggi ke terendah
    $sortedResults = $filteredResults->sortByDesc('total');

    // Ambil user data untuk ditampilkan
    $data = $sortedResults->map(function ($item) {
        $user = User::find($item['user_id']);
        return [
            'user' => $user,
            'total' => round($item['total'], 2), // Bulatkan dua angka desimal
            'periode' => $item['periode'],
            'projects' => $item['projects'],
        ];
    });

    // Kirim ke view
    return view('pages.manajerhc.perpnajang.index', compact('data'));
}


    


}
