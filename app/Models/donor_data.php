<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class donor_data extends Model
{
    use HasFactory;

    public function organizations()
    {
        return $this->morphMany(OrganizationMember::class, 'member');
    }
}
