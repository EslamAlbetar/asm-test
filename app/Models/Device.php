<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    public function totalItem()
    {
        return $this->belongsTo(TotalItems::class, 'total_item_id');
    }

    public function bill()
    {
        return $this->belongsTo(Bill::class, 'total_item_id');
    }
    
}
