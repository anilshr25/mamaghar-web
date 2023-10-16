<?php

namespace App\Models\Adventure\Category;

use App\Services\Traits\Loggable;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdventureCategory extends Model
{
    use HasFactory, Sluggable, SoftDeletes, Loggable;

    protected $uploadPath = 'uploads/adventure/category';

    protected $fillable = [
        'title',
        'slug',
        'cover_image',
        'description',
        'is_active'
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
            ],
        ];
    }

    protected $appends = ['file_path'];

    public function getFilePathAttribute()
    {
        if (!empty($this->cover_image)) {
            return getFilePath($this->uploadPath, $this->cover_image);
        }
        return [];
    }

    public function category()
    {
        return $this->belongsTo(AdventureCategory::class, 'category_id');
    }
}
