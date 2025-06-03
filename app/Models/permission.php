<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Permission extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'time_per',
        'start_end_per',
        'reason_per',
        'status_per',
        'signature',
        'reason_admin'
    ];




    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
