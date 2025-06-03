<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PositionName extends Model
{
    protected $table = 'position_names';
    
    public function category()

    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function situations()
    {
        return $this->hasMany(Situation::class, 'position_id');
    }

    public function patients()
{
    return $this->belongsToMany(Patient::class, 'patient_position', 'position_id', 'patient_id');
}

public function allpatients()
{
    return $this->belongsToMany(AllPatient::class, 'patient_position', 'position_id', 'patient_id');
}

}
