<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'staff_id',
        'year',
        'month',
        'amount',
        'status'
    ];

    public function payments()
    {
        return $this->hasMany(SalaryPayment::class, 'transaction_id');
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }
}
