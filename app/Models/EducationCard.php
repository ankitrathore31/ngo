<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EducationCard extends Model
{
    use HasFactory;
    protected $fillable = [
        'reg_id',
        'educationcard_no',
        'education_registration_date',
        'students',
        'school_name',
        'status',
    ];

    protected $casts = [
        'students' => 'array',
        'school_name' => 'array',
    ];

    public function educationCards()
    {
        return $this->hasMany(EducationCard::class, 'reg_id', 'id');
    }

    public function beneficiary()
    {
        return $this->belongsTo(beneficiarie::class, 'reg_id');
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'reg_id');
    }

    public function educationFacilities()
    {
        return $this->hasMany(EducationFacility::class, 'card_id');
    }
}
