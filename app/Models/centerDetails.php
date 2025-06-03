<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class centerDetails extends Model
{
    protected $fillable = [
        'first_name',
        'second_name',
        'target_pat_td',
        'target_pat_mon',
        'address',
        'phone',
    ];
}
