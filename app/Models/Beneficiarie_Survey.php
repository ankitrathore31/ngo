<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Beneficiarie_Survey extends Model
{
    use HasFactory;
    protected $fillable = [
        'academic_session',
        'ngo_id',
        'beneficiarie_id',
        'survey_details',
        'survey_date',
        'survey_officer',
        'facilities_category',
        'facilities',
        'facilities_status',
        'distribute_date',
        'distribute_place',
        'pending_reason',
        'status',
    ];
    protected $casts = [
        'surveyfacility_status' => 'array',
    ];

    public function beneficiarie()
    {
        return $this->belongsTo(beneficiarie::class, 'beneficiarie_id');
    }
}
