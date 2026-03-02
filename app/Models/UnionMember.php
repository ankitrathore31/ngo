<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class UnionMember extends Model
{
    use HasFactory;
    protected $fillable = [
        'union_id',
        'member_id',
        'member_by',
        'join_date',
        'expiry_date',
        'status'
    ];

    protected $dates = ['join_date', 'expiry_date'];

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    public function union()
    {
        return $this->belongsTo(Union::class, 'union_id');
    }

    // Check if expired
    public function isExpired()
    {
        return Carbon::today()->gt($this->expiry_date);
    }
}
