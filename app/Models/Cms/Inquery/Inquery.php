<?php

namespace App\Models\Cms\Inquery;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inquery extends Model
{
    use HasFactory, Sluggable;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone_no',
        'subject',
        'message',
        'is_replied',
        'status',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'first_name',
                'on_update' => true,
            ]
        ];
    }
}
