<?php

namespace App\Models\AdminUser;

use App\Services\Traits\Loggable;
use App\Services\Traits\UploadPathTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class AdminUser extends Authenticatable
{
    use Notifiable, SoftDeletes, UploadPathTrait, Loggable, HasRoles;

    protected $uploadPath = 'admin-user';

    protected $guard_name = 'admin';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'image',
        'password',
        'unique_identifier',
        'address_line_1',
        'address_line_2',
        'mobile_no',
        'user_type',
        'is_login_verified',
        'is_email_authentication_enabled',
        'is_mfa_enabled',
        'mfa_secret_code',
        'mfa_authentication_image',
        'is_active'
    ];

    protected $hidden = ['password', 'mfa_secret_code', 'mfa_authentication_image', 'remember_token'];

    protected $appends = ['full_name', 'image_path', 'symbol_label', 'full_address'];

    public function getSymbolLabelAttribute()
    {
        if(!empty($this->first_name) && !empty($this->last_name)) {
            $first_name = str_split(preg_replace('/[()]/', '', ucfirst($this->first_name)), 1)[0];
            $last_name = str_split(preg_replace('/[()]/', '', ucfirst($this->last_name)), 1)[0];
            return $first_name.$last_name;
        }else {
            $first_name = str_split(preg_replace('/[()]/', '', ucfirst($this->first_name)), 1)[0];
            $first_name = $first_name . str_split(preg_replace('/[()]/', '', ucfirst($this->first_name)), 1)[1];
            return $first_name;
        }
    }
    public function getFullAddressAttribute()
    {
        if(!empty($this->address_line_1) && !empty($this->address_line_2)) {
            $address_line_1 = ucfirst($this->address_line_1);
            $address_line_2 = ucfirst($this->address_line_2);
            return $address_line_1.', '.$address_line_2;
        }else {
            $address_line_1 = ucfirst($this->address_line_1);
            return $address_line_1;
        }
    }

    public function getFullNameAttribute()
    {
        if (!empty($this->middle_name))
            return ucfirst($this->first_name." ".$this->middle_name." ".$this->last_name);
        else
            return ucfirst($this->first_name." ".$this->last_name);

    }

    public function getImagePathAttribute()
    {
        if($this->user_type == "staff"){
            $this->uploadPath = 'staff';
        }
        if (!empty($this->image)) {
            $this->uploadPath = $this->getUploadPath($this->uploadPath, $this->unique_identifier);
            return [
                "original" => asset($this->uploadPath . '/' . $this->image),
                "thumb" => asset($this->uploadPath . '/thumb/' . $this->image)
            ];
        }
    }
}
