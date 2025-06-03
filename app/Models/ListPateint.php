<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class ListPateint extends Model
{
    use HasFactory;  
    
    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    public function position()
    {
        return $this->hasOne('App\Models\PositionName', 'id', 'position_id');
    }

    public function location()
    {
        return $this->hasOne('App\Models\Location', 'id', 'location_id');
    }

    public function patient()
    {
        return $this->hasOne('App\Models\Patient', 'id', 'patient_id ');
    }
    
    public function allpatient()
    {
        return $this->hasOne('App\Models\AllPatient', 'id', 'patient_id ');
    }
}
