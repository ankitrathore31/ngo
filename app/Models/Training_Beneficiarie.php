<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Training_Beneficiarie extends Model
{
    use HasFactory;

    public function center()
    {
        return $this->belongsTo(Training_Center::class, 'center_code', 'center_code');
    }

    public function beneficiare()
    {
        return $this->belongsTo(beneficiarie::class, 'beneficiarie_id');
    }
}
