<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    public function donor()
    {
        return $this->belongsTo(donor_data::class, 'donor_id');
    }
}
