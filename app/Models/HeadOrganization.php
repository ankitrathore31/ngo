<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeadOrganization extends Model
{
    use HasFactory;
    protected $fillable = [
        'academic_session',
        'name',
    ];

    public function organizations()
    {
        return $this->hasMany(Organization::class, 'headorg_id');
    }

    public function organizationMembers()
    {
        return $this->hasMany(OrganizationMember::class, 'headorg_id');
    }

    protected static function booted()
    {
        static::deleting(function ($headOrg) {
            // Delete all related organization members
            $headOrg->organizationMembers()->delete();

            // Delete all organizations (and their members if needed)
            foreach ($headOrg->organizations as $organization) {
                // Delete members related to this organization
                $organization->organizationMembers()->delete();
                $organization->delete();
            }
        });
    }
}
