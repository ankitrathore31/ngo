<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BudgetItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'report_id',
        'category',
        'expense',
        'details',
    ];

    public function report(){
        return $this->belongsTo(ProjectReport::class, 'report_id');
    }
}
