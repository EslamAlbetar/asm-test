<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{

    protected $fillable = [
        'name',
        'type',
        'required_quantity',
        'supplier',
        'category',
        'price',
        'discount',
        'expiration_date',
        'comments_bill',
        'image',
        'total_item_id'
    ];

    public function getTotalAttribute()
    {
        $price = (float)$this->price;
        $discount = (float)$this->discount;
        return $price - ($price * ($discount / 100));
    }

    public function totalItem()
    {
        return $this->belongsTo(TotalItems::class, 'total_item_id');
    }

    public function addItems()
    {
        return $this->hasMany(AddItem::class, 'total_items_id', 'total_item_id');
    }
}
