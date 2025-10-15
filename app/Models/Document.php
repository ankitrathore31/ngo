<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'file_name',
        'file_path',
        'file_type',
        'file_size',
        'description',
        'download_count',
        'is_active',
        'uploaded_by'
    ];

    // Relationship with User
    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    // Accessor for file size in human readable format
    public function getFileSizeFormattedAttribute()
    {
        $size = $this->file_size;
        if ($size < 1024) {
            return $size . ' KB';
        } else {
            return round($size / 1024, 2) . ' MB';
        }
    }
}
