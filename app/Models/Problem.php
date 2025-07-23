<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Problem extends Model
{
    use HasFactory;

      protected $fillable = [
        'problem_no',
        'problem_date',
        'academic_session',
        'address',
        'block',
        'state',
        'district',
        'description',
        'problem_by',
        'problem_solution',
        'solution_date',
        'solution_by',
        'solution_description',
        'status',
    ];
}
