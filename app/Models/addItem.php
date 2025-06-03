<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AddItem extends Model
{
    public function categoryItem()
    {
        return $this->belongsTo(TotalItems::class, 'category', 'id');
    }

    public function totalItem()
    {
        return $this->belongsTo(TotalItems::class, 'total_items_id');
    }

    public function scopeVisible($query)
    {
        return $query->where('is_hidden', false);
    }

    public function scopeHidden($query)
    {
        return $query->where('is_hidden', true);
    }
}
