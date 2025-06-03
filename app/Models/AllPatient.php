<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AllPatient extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_user',
        'full_name',
        'phone',
        'address',
        'age',
        'gender',
        'dr_name',
        'category',
        'positions',
        'situations',
        'complaint',
        'location',
        'price',
        'discount',
        'finalPrice',
        'payment',
        'comments',
        'image',
        'status',
        'report',
        'report_details',
        'doctor_signature',
    ];

    // العلاقات
    public function positions()
    {
        return $this->belongsToMany(PositionName::class, 'patient_position', 'patient_id', 'position_id');
    }

    public function categoryData()
    {
        return $this->belongsTo(\App\Models\Category::class, 'category'); // لاحظ الكابيتال C هنا
    }

    public function getCategoryNameAttribute()
    {
        $categoryId = json_decode($this->category, true);

        if (is_array($categoryId)) {
            $categoryId = $categoryId[0] ?? null;
        }

        if (!$categoryId) return null;

        return \App\Models\Category::find($categoryId)?->name;
    }

    public function locationData()
    {
        return $this->belongsTo(Location::class, 'location');
    }

    // ✅ هنا تحط accessor بتاع position names
    public function getPositionNamesAttribute()
    {
        $positionIds = json_decode($this->positions, true);
        if (!$positionIds || !is_array($positionIds)) return [];

        return \App\Models\PositionName::whereIn('id', $positionIds)->pluck('position_name')->toArray();
    }

    // ✅ ولو عايز تظهرها تلقائيًا لما ترجع بيانات الـ Patient
    protected $appends = ['position_names'];

    protected $appendes = ['category_name'];



    public function getSituationNamesAttribute()
    {
        $situationIds = json_decode($this->situations, true);
        if (!$situationIds || !is_array($situationIds)) return [];

        return Situation::whereIn('id', $situationIds)->pluck('situation_name')->toArray();
    }
}
