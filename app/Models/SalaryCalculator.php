<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryCalculator extends Model
{
    use HasFactory;

    protected $table = 'salary_calculators';

    protected $fillable = ['id_user', 'base_salary', 'hourly_shift', 'gools_day'];
    protected $casts = [
        'base_salary' => 'decimal:2',
        'hourly_shift' => 'integer',
        'gools_day' => 'integer'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function calculateMonthlySalary($totalHours)
    {
        return $this->base_salary + ($totalHours * $this->hourly_rate);
    }
}