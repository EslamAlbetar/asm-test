<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinancialAccounting extends Model
{
    protected $table = 'financial_accounting';
    protected $fillable = ['inputs', 'outputs', 'gross_profit'];

}
