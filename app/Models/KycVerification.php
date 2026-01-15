<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KycVerification extends Model
{
    use HasFactory;
    protected $fillable = [
        'beneficiarie_id',
        'aadhaar_no',
        'aadhaar_front',
        'aadhaar_back',
        'verified_by',
        'verified_at',
    ];

    public function beneficiarie()
    {
        return $this->belongsTo(beneficiarie::class, 'beneficiarie_id');
    }
}
