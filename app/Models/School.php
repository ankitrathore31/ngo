<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;
      protected $fillable = [
        'school_code',
        'registration_date',
        'school_name',
        'contact_number',
        'address',
        'principal_name',
        'affiliation_board',
        'registration_no',
        'principal_aadhar',
        'registration_certificate',
        'affiliation_certificate',
        'principal_appointment_letter',
        'principal_aadhar_document',
        'status',
    ];
}
