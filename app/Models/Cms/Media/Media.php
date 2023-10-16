<?php

namespace App\Models\Cms\Media;

use App\Services\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Media extends Model
{
    protected $uploadPath = "uploads/media";

    protected $table = "medias";

    use HasFactory, SoftDeletes, Loggable;

    protected $fillable = [
        "position",
        "type",
        "image",
    ];

    protected $appends = [
        "image_path"
    ];

    public function getImagePathAttribute()
    {
        if (!empty($this->image)) {
            return getFilePath($this->uploadPath, $this->image);
        }
        return [];
    }
}
