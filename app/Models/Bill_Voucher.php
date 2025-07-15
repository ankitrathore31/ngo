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
        'academic_session',

        // Seller details
        'shop',
        'role',
        's_name',
        's_address',
        's_mobile',
        's_email',
        's_pan',
        'gst',

        // Buyer details
        'b_name',
        'b_mobile',
        'b_email',
        'b_address',
        'cgst',
        'sgst',
        'igst',
    ];

    public function items()
    {
        return $this->hasMany(Voucher_Item::class, 'bill_voucher_id');
    }
}
