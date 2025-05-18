<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class beneficiarie extends Model
{
    use HasFactory;
    protected $fillable = [
        'application_date',
        'application_no',
        'registration_date',
        'registration_no',
        'name',
        'reg_type',
        'dob',
        'gender',
        'phone',
        'gurdian_name',
        'mother_name',
        'village',
        'post',
        'block',
        'state',
        'district',
        'pincode',
        'country',
        'email',
        'religion',
        'religion_category',
        'caste',
        'image',
        'identity_type',
        'identity_no',
        'id_document',
        'occupation',
        'help_needed',
        'help_by_ngo',
        'survey_details',
        'eligibility',
        'marital_status',
        'area_type',
        'status',
    ];

}
