<?php

namespace App\Models\Cms\Album\Value;

use App\Models\Album\Album;
use App\Services\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AlbumValue extends Model
{
    use HasFactory, SoftDeletes, Loggable;

    protected $uploadPath = "uploads/album/value";

    protected $fillable = [
        'album_id',
        'title',
        'position',
        'path',
        'is_featured',
    ];

    protected $appends = [
        "image_path"
    ];

    public function getImagePathAttribute()
    {
        $imagePath = [];
        if (!empty($this->path)) {
            $imagePath = getFilePath($this->uploadPath, $this->path);
        }
        return $imagePath;
    }

    public function albumb()
    {
        return $this->belongsTo(Album::class, 'album_id');
    }
}
