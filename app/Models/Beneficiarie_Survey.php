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
        'facilities_category',
        'facilities',
        'status',
    ];

    public function beneficiarie()
    {
        return $this->belongsTo(beneficiarie::class, 'beneficiarie_id');
    }
}
