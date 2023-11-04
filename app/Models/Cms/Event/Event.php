<?php

namespace App\Models\Cms\Event;

use App\Models\Cms\Event\Gallery\EventGallery;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory, Sluggable, SoftDeletes;

    protected $uploadPath = 'event';

    protected $fillable = [
        'title',
        'slug',
        'description',
        'image',
        'location',
        'start_date',
        'end_date',
        'event_time',
        'is_active'
    ];

    public function sluggable(): array

    {
        return [
            'slug' => [
                'source' => 'title',
                'separator' => '-',
                'unique' => true,
                'on_update' => true,
            ]
        ];
    }

    protected $appends = ['image_path'];

    public function getImagePathAttribute()
    {
        if (!empty($this->image)) {
            $uploadPath = getUploadPath($this->uploadPath);
            return getFilePath($uploadPath, $this->image, true);
        }
        return [];
    }

    public function event_galleries()
    {
        return $this->hasMany(EventGallery::class, 'event_id');
    }
}
