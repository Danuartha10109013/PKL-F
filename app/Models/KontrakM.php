<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KontrakM extends Model
{
    use HasFactory;

    // Specify the table name if it doesn't follow Laravel's convention
    protected $table = 'kontrak';

    // Specify the fillable fields for mass assignment
    protected $fillable = [
        'user_id',
        'awal_kontrak',
        'akhir_kontrak',
        'periode',
        'no_bpjs',
        'no_bpjstk',
        'lokasi_bpjs',
        'terdaftar_bpjstk',
        'status_pegawai',
    ];

    // Optionally, you can define any relationships here
    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }
}
