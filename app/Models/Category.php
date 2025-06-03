<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function positions()
    {
        return $this->hasMany(PositionName::class, 'category_id');
    }
}
