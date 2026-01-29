<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EducationFacility extends Model
{
    use HasFactory;

    protected $fillable = [
        'reg_id',
        'card_id',
        'fees_type',
        'school',
        'registration_no',
        'fees_slip_no',
        'fees_submit_date',
        'fees_amount',
        'slip',
        'status',
        'investigation_officer',
        'person_paying_amount',
        'account_no',
        'account_holder_name',
        'ifsc_code',
        'bank_name',
        'bank_branch',
        'account_holder_address',
        'verify_officer',
        'investigation_proof',
    ];


    public function educationCard()
    {
        return $this->belongsTo(EducationCard::class, 'card_id');
    }
}
