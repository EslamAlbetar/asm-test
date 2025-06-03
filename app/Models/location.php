<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class location extends Model
{
    use HasFactory;
 
    protected $fillable = [
     'location_name',
 ];
 }
