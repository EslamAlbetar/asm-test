<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\PositionName; // تأكد إنه متضاف في الأعلى

class Situation extends Model
{
    protected $fillable = [
        'situation_name',
        'price',
        'position_id'
    ];

    public function position()
    {
        return $this->belongsTo(PositionName::class, 'position_id');
    }
}
