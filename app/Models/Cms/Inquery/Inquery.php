<?php

namespace App\Models\Cms\Inquery;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inquery extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone_no',
        'subject',
        'message',
        'is_replied',
        'is_active',
    ];


}
