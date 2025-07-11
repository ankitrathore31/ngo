<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher_Item extends Model
{
    use HasFactory;
    protected $tabel = 'voucher__items';
    protected $fillable = [
        'bill_voucher_id',
        'product',
        'qty',
        'rate'
    ];

    public function bill()
    {
        return $this->belongsTo(Bill_Voucher::class, 'bill_voucher_id');
    }
}
