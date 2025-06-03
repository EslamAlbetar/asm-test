<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Partener extends Model
{
    protected $fillable = [
        'id_user',
        'user_id',
        'name_partener',
        'age',
        'address',
        'phone',
        'job',
        'amount',
        'percentage',
        'total_profits_you'
    ];

    protected $casts = [
        'percentage' => 'float',
        'amount' => 'float',
        'total_profits_you' => 'float'
    ];

    public function hostUser()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function partnerUser()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
    
}
