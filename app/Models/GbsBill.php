<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GbsBill extends Model
{
    use HasFactory;
    protected $fillable = [
        'academic_session',
        'bill_date',
        'name',
        'guardian_name',
        'village',
        'post',
        'block',
        'state',
        'district',
        'branch',
        'centre',
        'date',
        'work',
        'amount',
        'payment_method',
        'cheque_no',
        'transaction_no',
        'transaction_date',
        'account_number',
        'bank_name',
        'branch_name',
        'ifsc_code',
        'place',
    ];
}
