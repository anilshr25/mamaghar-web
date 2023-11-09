<?php

namespace App\Models\Service;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory, Sluggable, SoftDeletes;
    protected $uploadPath = "service";

    protected $fillable = [
        'title',
        'slug',
        'image',
        'short_description',
        'is_feature',
        'is_active',
    ];

    protected $appends = ['image_path'];

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

    public function getImagePathAttribute()
    {
        if (!empty($this->image)) {
            return getFilePath($this->uploadPath, $this->image, $this->title);

        }
    }
}
