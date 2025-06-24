<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExperienceCertificate extends Model
{
    use HasFactory;
    protected $fillable = [
        'letterNo',
        'academic_session',
        'date',
        'to',
        'subject',
        'letter',
    ];


}
