<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;
     protected $fillable = [
        'academic_session',
        'registration_no',
        'registration_date',
        'shop',
        'vendor_type',
        'name',
        'village',
        'post',
        'block',
        'state',
        'district',
        'mobile',
        'email',
        'shop_gst_no',
        'operator_gst_no',
        'shop_gst_file',
        'operator_gst_file',
        'vendor_pan_no',
        'operator_pan_no',
        'shop_pan_file',
        'operator_pan_file',
    ];
}
