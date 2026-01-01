<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    use HasFactory;
    protected $fillable = [
        'hospital_code',
        'hospital_name',
        'address',
        'contact_number',
        'operator_name',
        'registration_date',
        'status',
        'operator_aadhar',
        'operator_degree',
        'gst_no',
        'license_no',
        'gst_document',
        'license_document',
        'operator_degree_document',
        'operator_aadhar_document'
    ];
}
