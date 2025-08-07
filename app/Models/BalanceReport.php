<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BalanceReport extends Model
{
    use HasFactory;
    protected $fillable = [
        'year',
        'month',
        'total_income',
        'total_expenditure',	
        'remaining_amount',
    ];
}
