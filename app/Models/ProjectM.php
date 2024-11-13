<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectM extends Model
{
    use HasFactory;
    protected $table = 'project';
    protected $fillable = [
        'judul',
        'kode_project',
        'deskripsi',
        'status',
        'start',
        'end',
        'kode_uk',
        'divisi',
        'unit_kerja',
        // 'gaji',
        'start',
        'end',
        'pegawai_id',
        'kategori',
        'statusin',
        'sbu',
    ] ;
}
