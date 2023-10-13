<?php

namespace App\Models\RolePermission;

use App\Services\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserCustomRolePermission extends Model
{
    use HasFactory, SoftDeletes, Loggable;

    protected $fillable = [
        'admin_user_id',
        'role_id',
        'permission_id',
        'group_name',
        'permission_name'
    ];
}
