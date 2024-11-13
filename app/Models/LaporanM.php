<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanM extends Model
{
    use HasFactory;

    protected $table = 'laporan';

    protected $fillable = [
        'project_id',
        'user_id',
        'pencapaian',
        'ringkasan',
        'hasil',
        'kendala',
        'solusi',
        'rencana',
        'inisiatif_tambahan',
        'catatan',
    ];
}
