<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donations extends Model
{
    protected $attributes = [
        'name' => 'لا يوجد',
        'age' => 'لا يوجد',
        'address' => 'لا يوجد',
        'phone' => 'لا يوجد',
        'reason' => 'لا يوجد',
    ];

    protected $fillable = [
        'name',
        'age',
        'address',
        'phone',
        'amount',
        'reason',
        'date'
    ];
}
