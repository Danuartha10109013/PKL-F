<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryPerpanjanganM extends Model
{
    use HasFactory;

    protected $table = 'history_perpanjangan';
    protected $fillable = [
        'user_id',
        'jumlah_perpanjangan',
        'tanggal_perpanjangan',
        'awal',
        'akhir',
    ];
}
