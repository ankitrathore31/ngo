<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkPlan extends Model
{
    use HasFactory;
    // protected $tabel = "";

    protected $fillable = [
        'academic_session',
        'project_code',
        'project_name',
        'center',
        'state',
        'district',
        'animator_code',
        'name',
        'month_of',
        'date',
        'to',
    ];

    public function plans()
    {
        return $this->hasMany(Plan::class, 'workplan_id');
    }
}
