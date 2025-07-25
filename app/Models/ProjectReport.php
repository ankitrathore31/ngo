<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectReport extends Model
{
    use HasFactory;
    protected $fillable =[
        'academic_session',
        'project_id',
        'report',
        'mission',
        'conclusion',
    ];

    public function items(){
        return $this->hasMany(BudgetItem::class, 'report_id');
    }

}
