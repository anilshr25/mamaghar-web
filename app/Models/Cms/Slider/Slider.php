<?php

namespace App\Models\Cms\Slider;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Slider extends Model
{
    use HasFactory, Sluggable, SoftDeletes;

    protected $uploadPath = "slider";

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
                'on_update' => true,
            ]
        ];
    }

    protected $fillable = [
        'title',
        'slug',
        'description',
        'image',
        'link',
        'position',
        'new_tab',
        'heading_text',
        'sub_heading_text',
        'button_text',
        'show_button',
        'is_active',
    ];

    protected $appends = ['image_path'];

    public function getImagePathAttribute()
    {
        if (!empty($this->image)) {
            $uploadPath = getUploadPath($this->uploadPath, $this->title);
            return getFilePath($uploadPath, $this->image, true);
        }
    }
}
