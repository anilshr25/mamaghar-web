<?php

namespace App\Models\Room;

use App\Models\Room\Category\RoomCategory;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
    use HasFactory, Sluggable, SoftDeletes;
    protected $uploadPath = "room";

    protected $fillable = [
        'title',
        'slug',
        'category_id',
        'image',
        'price',
        'room_number',
        'adult_number',
        'kid_number',
        'description',
        'is_active',
    ];

    protected $appends = ['image_path'];

    public function category()
    {
        return $this->belongsTo(RoomCategory::class, 'category_id');
    }

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
