<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ngo extends Model
{
    protected $fillable = [
        'ngo_name',
        'founder_name' => 'founder',
        'email',
        'phone_number',
        'user_type',
        'password',
    ];

    use HasFactory;
}
