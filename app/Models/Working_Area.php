<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Working_Area extends Model
{
    use HasFactory;
     protected $fillable = [
        'academic_session',
        'area_type',
        'area',
    ];
}
