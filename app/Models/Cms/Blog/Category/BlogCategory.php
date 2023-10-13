<?php

namespace App\Models\Cms\Blog\Category;

use App\Models\Cms\Blog\Blog;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogCategory extends Model
{
    use HasFactory, SoftDeletes, Sluggable;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'is_active',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
            ],
        ];
    }

    protected $appends = ['blogs', 'blogs_count'];

    public function getBlogsAttribute()
    {
        return Blog::whereIn('id', [$this->id])->whereIsActive(1)->select('id', 'title')->get();
    }

    public function getBlogsCountAttribute()
    {
        $blogs = $this->blogs;
        return count($blogs);
    }
}
