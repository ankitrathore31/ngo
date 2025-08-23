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
        'payment_mode',
        'bank_name',
        'bank_no',
        'ifsc_code',
        'cheque_no',
        'upi_id',
        'transaction_id',
        'status'
    ];
    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }
}
