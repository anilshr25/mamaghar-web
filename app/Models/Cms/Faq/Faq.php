<?php

namespace App\Models\Cms\Faq;

use App\Models\Cms\Faq\Category\FaqCategory;
use App\Services\Traits\Loggable;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Faq extends Model
{
    use HasFactory, Sluggable, SoftDeletes, Loggable;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'faq_category_id',
        'position',
        'is_active',
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

    public function faq_category(){
        return $this->belongsTo(FaqCategory::class,'faq_category_id');
    }


}
