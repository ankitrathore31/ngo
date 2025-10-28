<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'benefres_survey_id',
        'aadhar_guardian',
        'account_no_guardian',
        'aay_jati_nivas_guardian',
        'adhyan_pramn_patr_guardian',
        'ration_card_guardian',
        'color_photo_guardian',
        'mobile_aadhar_link_guardian',
        'signature_thumb_guardian',
        'aay_jati_nivas_beneficiary',
        'remark',
    ];

    protected $casts = [
        'aadhar_guardian' => 'boolean',
        'account_no_guardian' => 'boolean',
        'aay_jati_nivas_guardian' => 'boolean',
        'adhyan_pramn_patr_guardian' => 'boolean',
        'ration_card_guardian' => 'boolean',
        'color_photo_guardian' => 'boolean',
        'mobile_aadhar_link_guardian' => 'boolean',
        'signature_thumb_guardian' => 'boolean',
        'aay_jati_nivas_beneficiary' => 'boolean',
    ];

    /**
     * Relationship with BenfresSurvey
     */
    // public function SurveyBenefries()
    // {
    //     return $this->belongsTo(SurveyBenefries::class, 'benefres_survey_id');
    // }
}
