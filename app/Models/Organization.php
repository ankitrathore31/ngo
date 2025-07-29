<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory;
    protected $fillable = [
        'academic_session',
        'headorg_id',
        'organization_no',
        'name',
        'formation_date',
        'address',
        'block',
        'state',
        'district',
    ];

    public function headOrganization()
    {
        return $this->belongsTo(HeadOrganization::class, 'headorg_id');
    }

    public function organizationMembers()
    {
        return $this->hasMany(OrganizationMember::class);
    }
    
}
