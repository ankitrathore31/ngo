<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    use HasFactory;

    protected $table = 'stories'; // or your actual table name

    protected $fillable = [
        'file_path',
        'description',
        'date',
        'link',
        'name',
    ];
}
