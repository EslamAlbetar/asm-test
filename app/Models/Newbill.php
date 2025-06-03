<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Newbill extends Model
{
    protected $fillable = [
        'id_user',
        'bill_name',
        'bill_type',
        'required_qty',
        'price_bill',
        'comments_bill'
    ];
}
