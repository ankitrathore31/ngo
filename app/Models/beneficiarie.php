<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class beneficiarie extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'academic_session',
        'ngo_id',
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
        'eligibility',
        'marital_status',
        'area_type',
        'delete_reason',
        'delete_date',
        'status',
        'survey_status',
    ];

    public function surveys()
    {
        return $this->hasMany(Beneficiarie_Survey::class, 'beneficiarie_id');
    }

    public function firstSurvey()
    {
        return $this->hasOne(Beneficiarie_Survey::class)->orderBy('id', 'asc');
    }

    public function uniqueSurvey()
    {
        return $this->hasOne(Beneficiarie_Survey::class)
            ->orderBy('id', 'asc');
    }

    public function centers()
    {
        return $this->hasMany(Training_Beneficiarie::class, 'beneficiarie_id')
            ->orderBy('id', 'asc');
    }

    public function experience()
    {
        return $this->hasMAny(ExperienceCertificate::class . 'beneficiarie_id')
            ->orderBy('id', 'asc');
    }

    public function organizations()
    {
        return $this->hasMany(OrganizationMember::class, 'member_id');
    }
    public function healthCard()
    {
        return $this->hasMany(\App\Models\HealthCard::class, 'reg_id', 'id');
    }
    public function educationCards()
    {
        return $this->hasMany(\App\Models\EducationCard::class, 'reg_id', 'id');
    }
}
