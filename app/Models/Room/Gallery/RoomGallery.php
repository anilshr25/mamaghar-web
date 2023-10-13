<?php

namespace App\Models\Room\Gallery;

use App\Models\Room\Room;
use App\Services\Traits\Loggable;
use App\Services\Traits\UploadPathTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoomGallery extends Model
{
    use HasFactory, SoftDeletes, UploadPathTrait, Loggable;

    protected $uploadPath = 'room/gallery';

    protected $fillable = [
        'room_id',
        'type',
        'is_feature_image',
        'position',
        'file',
        'is_active'
    ];

    protected $appends = ['file_path'];

    public function getFilePathAttribute()
    {
        if (!empty($this->file)) {
            $uploadPath = $this->getUploadPath($this->uploadPath);
            return getFilePath($uploadPath, $this->file);
        }
        return [];
    }

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }
}
