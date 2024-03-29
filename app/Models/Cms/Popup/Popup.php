<?php

namespace App\Models\Cms\Popup;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Popup extends Model
{
    use HasFactory, Sluggable, SoftDeletes;

    protected $uploadPath = 'popup';

    protected $fillable = [
        'title',
        'slug',
        'description',
        'type',
        'link_url',
        'file',
        'start_date',
        'end_date',
        'is_active',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
                'on_update' => true,
            ]
        ];
    }

    protected $appends = ['file_path'];

    public function getFilePathAttribute()
    {
        if (!empty($this->file)) {
            return getFilePath($this->uploadPath, $this->image, $this->title);
        }

    }
}
