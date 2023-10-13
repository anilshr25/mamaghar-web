<?php

namespace App\Models\Adventure;

use App\Models\Adventure\Category\AdventureCategory;
use App\Services\Traits\Loggable;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Adventure extends Model
{
    use HasFactory, Sluggable, SoftDeletes, Loggable;

    protected $fillable = [
        'title',
        'slug',
        'category_id',
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

    public function category()
    {
        return $this->belongsTo(AdventureCategory::class, 'category_id');
    }
}
