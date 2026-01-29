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
        'registration_no',
        'fees_slip_no',
        'fees_submit_date',
        'fees_amount',
        'slip',
        'status'
    ];


    public function educationCard()
    {
        return $this->belongsTo(EducationCard::class, 'card_id');
    }


}
