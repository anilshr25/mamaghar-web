<?php

namespace App\Models\Service;

use App\Services\Traits\UploadPathTrait;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory, Sluggable, SoftDeletes, UploadPathTrait;
    protected $uploadPath = "room";

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
            $uploadPath = $this->getUploadPath($this->uploadPath, $this->title);
            return [
                "original" => asset($uploadPath . '/' . $this->image),
                "thumb" => asset($uploadPath . '/thumb/' . $this->image)
            ];
        }
    }
}
