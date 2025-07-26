<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;

    protected $casts = [
        'permissions' => 'array',
    ];

    public function hasPermission($permission)
    {
        return in_array($permission, $this->permissions ?? []);
    }

    public function organizations()
    {
        return $this->hasMany(OrganizationMember::class, 'member_id');
    }
}
