<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class deduction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount_ded',
        'reason_ded',
        'status_ded',
        'signature_ded',
        'objection_ded',
        'objection_reason',
        'objection_status',
        'objection_reason',
        'reason_admin_objection',
        'signature_objection_admin',
    ];


    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
