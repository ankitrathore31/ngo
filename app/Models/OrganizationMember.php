<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrganizationMember extends Model
{
    use HasFactory;
    protected $fillable = [
        'academic_session',
        'headorg_id',
        'organization_id',
        'member_id',
        'member_position',
        'member_date',
    ];

    public function headOrganization()
    {
        return $this->belongsTo(HeadOrganization::class, 'headorg_id');
    }

    public function organization()
    {
        return $this->BelongsTo(Organization::class);
    }



    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }
}
