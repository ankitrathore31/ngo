<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HealthCard extends Model
{
    use HasFactory;
    protected $fillable = [
        'reg_id',
        'healthcard_no',
        'hospital_name',
        'diseases',
        'Health_registration_date',
        'status',
    ];

    protected $casts = [
        'diseases' => 'array'
    ];

    public function healthCards()
    {
        return $this->hasMany(HealthCard::class, 'reg_id', 'id');
    }
    public function beneficiary()
    {
        return $this->belongsTo(beneficiarie::class, 'reg_id');
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'reg_id');
    }
}
