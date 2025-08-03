<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill_Item extends Model
{
    use HasFactory;
     protected $fillable = [
        'bill_id',
        'product',
        'qty',
        'rate'
    ];

    public function bill()
    {
        return $this->belongsTo(Bill::class, 'bill_id');
    }
}
