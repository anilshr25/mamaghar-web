<?php

namespace App\Models\User\Address;

use App\Models\User\User;
use App\Services\Traits\Loggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use SoftDeletes, Loggable;

    protected $fillable = ['user_id', 'address_line_1', 'address_line_2', 'state', 'city', 'post_code', 'type', 'is_active'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
