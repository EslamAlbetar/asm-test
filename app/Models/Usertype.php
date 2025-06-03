<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usertype extends Model
{
    protected $fillable = ['name_usertype', 'color_code'];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
