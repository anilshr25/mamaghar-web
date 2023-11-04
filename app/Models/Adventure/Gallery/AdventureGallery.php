<?php

namespace App\Models\Adventure\Gallery;

use App\Models\Adventure\Adventure;
use App\Services\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdventureGallery extends Model
{
    use HasFactory, SoftDeletes, Loggable;

    protected $uploadPath = 'adventure/gallery';

    protected $fillable = [
        'adventure_id',
        'type',
        'position',
        'file',
        'is_active'
    ];

    protected $appends = ['file_path'];

    public function getFilePathAttribute()
    {
        if (!empty($this->file)) {
            $uploadPath = getUploadPath($this->uploadPath);
            return getFilePath($uploadPath, $this->file);
        }
        return [];
    }

    public function adventure()
    {
        return $this->belongsTo(Adventure::class, 'adventure_id');
    }
}
