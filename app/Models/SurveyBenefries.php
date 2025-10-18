<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyBenefries extends Model
{
    use HasFactory;
    protected $fillable = [
        // Survey-level data
        'user_id',
        'project_code',
        'project_name',
        'center',
        'animator_code',
        'animator_name',
        'session',
        'date',

        // Beneficiary-level data
        'name',
        'father_husband_name',
        'address',
        'state',
        'district',
        'block',
        'area_type',
        'post',
        'mobile_no',
        'caste',
        'age',
        'beneficiaries_type',
        'disability_percentage',
        'widow_since',
        'type_of_victim',
        'class',
        'place_identification_mark',
    ];
}
