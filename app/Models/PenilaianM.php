<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenilaianM extends Model
{
    use HasFactory;

    // Define the table name
    protected $table = 'penilaian';

    // Specify the fields that are mass assignable
    protected $fillable = [
        'user_id',
        'project_id',
        'hasil_kerja',
        'kualitas_kerja',
        'kepatuhan_sop',
        'keterangan',
    ];


}
