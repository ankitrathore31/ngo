<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryPayment extends Model
{
    use HasFactory;
    protected $fillable = [
        'transaction_id',
        'staff_id',
        'amount',
        'payment_date',
        'payment_mode',
        'bank_no',
        'bank_name',
        'ifsc_code',
        'cheque_no',
        'upi_id',
        'transaction_id_ref',
    ];

    public function transaction()
    {
        return $this->belongsTo(SalaryTransaction::class, 'transaction_id');
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }
}
