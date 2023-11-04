<?php

namespace App\Models\Cms\Blog;

use App\Models\Cms\Blog\Category\BlogCategory;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    use HasFactory, Sluggable, SoftDeletes;

    protected $uploadPath = 'blog';

    protected $fillable = [
        'title',
        'slug',
        'blog_type',
        'category_id',
        'publish_date',
        'description',
        'seo_title',
        'seo_keyword',
        'seo_description',
        'video_url',
        'author_name',
        'author_image',
        'is_featured',
        'is_active',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
                'on_update' => true,
            ],
        ];
    }

    protected $appends = ['author_image_path', 'categories'];

    public function getAuthorImagePathAttribute()
    {
        if (!empty($this->author_image)) {
            $uploadPath = getUploadPath($this->uploadPath, $this->title);
            return getFilePath($uploadPath, $this->author_image);
        }
    }

    public function getCategoriesAttribute()
    {
        if(!empty($this->category_id)){
            $category_id =  array_map('intval', explode(',', $this->category_id));
            return BlogCategory::whereIn('id', $category_id)->whereIsActive(1)->select('id', 'title')->get();
        }
        return [];
    }

}
