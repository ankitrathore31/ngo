<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HealthCard extends Model
{
    use HasFactory;
    protected $fillable = [
        'reg_id',
        'healthcard_no',
        'hospital_name',
        'diseases',
        'status',
    ];

    protected $casts = [
        'diseases' => 'array'
    ];
}
