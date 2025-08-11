<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Training_Center extends Model
{
    use HasFactory;
    // protected $table = 'training_centers'; // Make sure this matches your DB table

    protected $fillable = [
        'academic_session',
        'center_code',
        'center_name',
        'center_address',
        'post',
        'block',
        'district',
        'state',
        'incharge',
    ];
}
