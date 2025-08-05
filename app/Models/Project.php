<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'academic_session',
        'name',
        'code',
        'category',
        'sub_category',
        'image',
    ];

    public function reports()
    {
        return $this->hasMany(ProjectReport::class, 'project_id', 'id');
    }

    public static function getNamesFromValidCategories()
    {
        $categories = \App\Models\Category::pluck('category');
        return self::whereIn('category', $categories)->get();
    }
}
