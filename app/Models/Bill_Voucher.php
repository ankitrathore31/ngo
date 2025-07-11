<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill_Voucher extends Model
{
    use HasFactory;
    protected $table = 'bill_vouchers';
    protected $fillable = [
        'bill_no',
        'date',
        'name',
        'shop',
        'address',
    ];
}
