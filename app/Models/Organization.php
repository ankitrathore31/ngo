<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory;
    protected $fillable = [
        'academic_session',
        'name',
        'address',
        'block',
        'state',
        'district',
    ];

    public function organizationMembers(){
        return $this->hasMany(OrganizationMember::class);
    }
}
