<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vacation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'num_vac',
        'reason_vac',
        'status_vac',
        'signature',
        'reason_admin'
    ];


    protected $casts = [
        'num_vac' => 'integer'
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
