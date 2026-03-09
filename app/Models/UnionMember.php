<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class UnionMember extends Model
{
    use HasFactory;
    protected $fillable = [
        'union_id',
        'source_model',
        'source_id',
        'member_by',
        'added_by_type',

        'position_type',
        'position',
        'working_area',

        'identity_type',
        'identity_no',
        'id_document',

        'application_no',
        'application_date',
        'registration_no',
        'registration_date',
        'academic_session',

        'image',
        'name',
        'gurdian_name',
        'mother_name',
        'dob',
        'gender',
        'marital_status',
        'phone',
        'email',
        'occupation',
        'eligibility',

        'state',
        'district',
        'area_type',
        'block',
        'post',
        'village',
        'pincode',
        'country',

        'religion',
        'religion_category',
        'caste',

        'join_date',
        'expiry_date',
        'status',
    ];

    protected $casts = [
        'dob' => 'date',
        'join_date' => 'date',
        'expiry_date' => 'date',
        'application_date' => 'date',
        'registration_date' => 'date',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class, 'source_id');
    }
    // public function member()
    // {
    //     return $this->belongsTo(beneficiarie::class, 'source_id');
    // }

    public function union()
    {
        return $this->belongsTo(Union::class, 'union_id');
    }

    // Check if expired
    public function isExpired()
    {
        return Carbon::today()->gt($this->expiry_date);
    }
}
