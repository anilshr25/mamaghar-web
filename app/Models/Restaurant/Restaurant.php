<?php

namespace App\Models\Restaurant;

use App\Models\Restaurant\Category\RestaurantCategory;
use App\Services\Traits\Loggable;
use App\Services\Traits\UploadPathTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Restaurant extends Model
{
    use HasFactory, SoftDeletes, UploadPathTrait, Loggable;

    protected $uploadPath = "restaurant";

    protected $fillable = [
        'title',
        'category_id',
        'image',
        'price',
        'description',
        'is_active',
    ];

    protected $appends = ['image_path'];

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
    public function category()
    {
        return $this->belongsTo(RestaurantCategory::class, 'category_id');
    }
}
