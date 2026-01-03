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
        'bill_upload',
        'person_paying_bill',
        'investigation_officer',
        'verification_report',
        'bill_witness',
        'bill_witness_number',
        'bill_status',
        'status',
    ];

      public function healthCard()
    {
        return $this->belongsTo(HealthCard::class, 'card_id');
    }
}
