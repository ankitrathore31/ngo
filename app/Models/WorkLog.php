<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkLog extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id', 'user_type', 'user_name', 'user_code',
        'model_name', 'record_id', 'work_date', 'title', 'description'
    ];
}
