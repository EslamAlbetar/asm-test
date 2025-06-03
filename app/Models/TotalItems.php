<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TotalItems extends Model
{
    public function devices()
    {
        return $this->hasMany(Device::class, 'total_item_id');
    }
   
    public function addItems()
{
    return $this->hasMany(AddItem::class);
}


    protected $fillable = [
        'name', // أو أي أعمدة تانية عندك
        'total_price',
    ];
    
}
