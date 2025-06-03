<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DayRecord extends Model
{
    protected $fillable = [
        'category_id',
        'date',
        'inputs',
        'payments',
        'day_name', // ضيف السطر ده
    ];
}
