<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

       protected $fillable = [
        'workplan_id',     
        'work_date',
        'work_address',
        'work_name',
        'work_type',
        'worker_name',
        'work_with',
        'benefits',
    ];

     public function bill()
    {
        return $this->belongsTo(WorkPlan::class, 'workplan_id');
    }
}
