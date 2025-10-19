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

        'name',
        'father_husband_name',
        'state',
        'district',
        'area_type',
        'block',
        'post_town',
        'address',
        'mobile_no',
        'caste',
        'caste_category',
        'identity_type',
        'identity_no',
        'age',
        'beneficiaries_type',
        'disability_percentage',
        'widow_since',
        'type_of_victim',
        'class_name',
        'death_date',
        'labour_card_no',
        'labour_card_date',
        'land',
        'remark',
        'place_identification_mark',
        'created_at',
        'updated_at',
    ];
}
