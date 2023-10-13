<?php

namespace App\Models\User\PasswordReset;

use App\Models\AdminUser\AdminUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    use HasFactory;

    protected $fillable = ['email','token'];

    public function admin_user(){
        return $this->belongsTo(AdminUser::class,'email');
    }
}
