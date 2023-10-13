<?php

namespace App\Models\EmailTemplate;

use App\Services\Traits\Loggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmailTemplate extends Model
{
    use SoftDeletes,Loggable;

    protected $fillable = [
        'title',
        'identifier',
        'role',
        'category',
        'description',
        'type',
        'accepted_inputs',
        'is_active',
        'subject'
    ];
    protected $appends = [
        'status_text',
    ];
    function getStatusTextAttribute()
    {
        if ($this->is_active == 1)
            return 'Active';
        else
            return "Inactive";
    }
}
