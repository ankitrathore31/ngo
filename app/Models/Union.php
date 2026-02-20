<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Union extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'union_no',
        'union_certificate_format',
        'academic_session',
        'formation_date',
        'area_type',
        'address',
        'block',
        'state',
        'district',
    ];
}
