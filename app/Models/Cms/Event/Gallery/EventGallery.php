<?php

namespace App\Models\Cms\Event\Gallery;

use App\Models\Cms\Event\Event;
use App\Services\Traits\Loggable;
use App\Services\Traits\UploadPathTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventGallery extends Model
{
    use HasFactory, SoftDeletes, UploadPathTrait, Loggable;

    protected $uploadPath = 'event/gallery';

    protected $fillable = ['event_id', 'type', 'position', 'file', 'is_active'];

    protected $appends = ['file_path'];

    public function getFilePathAttribute()
    {
        if (!empty($this->file)) {
            $uploadPath = $this->getUploadPath($this->uploadPath);
            return getFilePath($uploadPath, $this->file, true);
        }
        return [];
    }

    public function event()
    {
        return $this->belongsTo(Event::class, 'even_id');
    }
}
