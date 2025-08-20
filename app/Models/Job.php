<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;
       protected $fillable = [
        'academic_session',
        'job_title',
        'position_id',
        'vacancy',
        'job_type',
        'location',
        'salary',
        'deadline',
        'description',
        'requirements',
        'status',
    ];

    public function position()
    {
        return $this->belongsTo(Position::class);
    }
}
