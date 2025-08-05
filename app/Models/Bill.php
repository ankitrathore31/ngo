<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;
     protected $fillable = [
        'bill_no',
        'date',
        'academic_session',
        'work_category',
        'work_name',
        'shop',
        'name',
        'email',
        'mobile',
        'address',
        'block',
        'district',
        'state',
        'cgst',
        'sgst',
    ];

    public function items()
    {
        return $this->hasMany(Bill_Item::class, 'bill_id');
    }
}
