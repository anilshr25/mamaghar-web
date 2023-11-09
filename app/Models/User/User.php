<?php

namespace App\Models\User;

use App\Models\Address\Address;
use App\Models\DiscountGroup\DiscountGroup;
use App\Models\User\CategoryBrandDiscount\UserCategoryBrandDiscount;
use App\Models\User\Setting\UserSetting;
use App\Services\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, SoftDeletes, Notifiable, Loggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'image',
        'unique_identifier',
        'mobile_no',
        'phone_no',
        'office_no',
        'type',
        'gender',
        'is_mfa_enabled',
        'is_email_authentication_enabled',
        'mfa_secret_code',
        'mfa_authentication_image',
        'email_verified_at',
        'is_login_verified',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'mfa_secret_code',
        'mfa_authentication_image'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $uploadPath = 'users';

    protected $appends = ['full_name', 'image_path', 'symbol_label'];

    public function getFullNameAttribute()
    {
        $nameArr[] = ucfirst($this->first_name);
        $nameArr[] = ucfirst($this->last_name);

        return trim(implode(' ', $nameArr));
    }

    function getSymbolLabelAttribute()
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

    public function getImagePathAttribute()
    {
        if (!empty($this->image)) {
            $uploadPath = getUploadPath($this->uploadPath, $this->unique_identifier);
            return [
                "original" => asset($uploadPath . '/' . $this->image),
                "thumb" => asset($uploadPath . '/thumb/' . $this->image)
            ];
        }
    }

    public function addresses()
    {
       return $this->hasMany(Address::class, 'user_id');
    }

    public function setting()
    {
       return $this->hasOne(UserSetting::class, 'user_id');
    }

    public function category_brand_discount()
    {
       return $this->hasMany(UserCategoryBrandDiscount::class, 'user_id');
    }

    public function discount_group()
    {
       return $this->belongsTo(DiscountGroup::class, 'discount_group_id');
    }

}
