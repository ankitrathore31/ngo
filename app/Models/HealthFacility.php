<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HealthFacility extends Model
{
    use HasFactory;
    protected $fillable = [
        'card_id',
        'reg_id',
        'treatment_type',
        'hospital_name',
        'bill_no',
        'bill_date',
        'bill_gst',
        'bill_amount',
        'clearness_amount',
        'bill_upload',
        'person_paying_bill',
        'investigation_officer',
        'verification_report',
        'verify_officer',
        'verify_proof',
        'investigation_proof',
        'account_no',
        'account_holder_name',
        'ifsc_code',
        'bank_name',
        'bank_branch',
        'account_holder_address',
        'reason',
        'work_category',
        'investigation_status',
        'remark',
        'status',
    ];

    public function healthCard()
    {
        return $this->belongsTo(HealthCard::class, 'card_id');
    }
}
