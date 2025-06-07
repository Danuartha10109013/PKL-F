<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnitKerjaM extends Model
{
    protected $table = 'unit_kerja';
    protected $fillable = [
        'unit_kerja',
        'kode_unit_kerja',
    ];
}
