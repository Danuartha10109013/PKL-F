<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusM extends Model
{
    protected $table = 'status';

    protected $fillable = [
        'status',
    ];
}
