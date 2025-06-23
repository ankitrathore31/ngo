<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExperienceCertificate extends Model
{
    use HasFactory;
    protected $fillable = [
        'certiNo',
        'academic_session',
        'beneficiarie_id',
        'date',
        'fromDate',
        'toDate',
    ];

    public function beneficiare()
    {
        return $this->belongsTo(beneficiarie::class, 'beneficiarie_id');
    }
    public function member()
    {
        return $this->belongsTo(Member::class, 'beneficiarie_id')->withDefault();
    }

    // Manually resolve relation: First check in Beneficiarie, then in Member
    public function person()
    {
        return $this->belongsTo(beneficiarie::class, 'beneficiarie_id')
            ->withDefault()
            ->union(
                Member::select('*')->whereColumn('id', 'beneficiarie_id')
            );
    }

    // Optional – You can write a helper method for clarity
    public function getPersonAttribute()
    {
        return beneficiarie::find($this->beneficiarie_id) ?? Member::find($this->beneficiarie_id);
    }
}
