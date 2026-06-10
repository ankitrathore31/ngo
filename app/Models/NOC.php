<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NOC extends Model
{
    use HasFactory;

    protected $fillable = [
        'noc_date',
        'noc_area',
        'issuer_name',
        'issuer_designation',
        'file_path',
        'file_original_name',
        'file_type',
    ];

    /**
     * Get the file extension / category label for display.
     */
    public function getFileLabelAttribute(): string
    {
        return match ($this->file_type) {
            'image' => 'Image',
            'pdf'   => 'PDF',
            default => 'File',
        };
    }

    /**
     * Check if the NOC file is an image.
     */
    public function isImage(): bool
    {
        return $this->file_type === 'image';
    }

    /**
     * Check if the NOC file is a PDF.
     */
    public function isPdf(): bool
    {
        return $this->file_type === 'pdf';
    }

    /**
     * Full public URL for the file.
     */
    public function getFileUrlAttribute(): string
    {
        return asset('noc_files/' . $this->file_path);
    }
}