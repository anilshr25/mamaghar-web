<?php

namespace App\Models\Cms\Faq\Category;

use App\Models\Cms\Faq\Faq;
use App\Services\Traits\Loggable;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FaqCategory extends Model
{
    use HasFactory, Sluggable, SoftDeletes, Loggable;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'position',
        'is_active',
    ];

    public function faqs(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Faq::class,'faq_category_id');
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}
