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
        // Decode manually if casting doesn't work
        $permissions = $this->permissions;

        if (is_string($permissions)) {
            $decoded = json_decode($permissions, true);
            $permissions = is_array($decoded) ? $decoded : [];
        }

        return in_array($permission, $permissions);
    }

    public function organizations()
    {
        return $this->hasMany(OrganizationMember::class, 'member_id');
    }
    public function transactions()
    {
        return $this->hasMany(SalaryTransaction::class);
    }
}
