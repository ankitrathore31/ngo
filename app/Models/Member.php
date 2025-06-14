<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'academic_session',
        'application_date',
        'application_no',
        'registration_no',
        'registration_date',
        'reg_type',
        'name',
        'marital_status',
        'area_type',
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
        'position_type',
        'position',
        'receipt_no',
        'status',
    ];
}
