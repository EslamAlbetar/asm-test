<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_user',
        'day',
        'status',
        'time',
        'started_at',
        'ended_at'
    ];

    
    // العلاقة مع جدول المستخدمين
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    
}