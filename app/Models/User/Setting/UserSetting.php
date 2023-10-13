<?php

namespace App\Models\User\Setting;


use App\Services\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserSetting extends Model
{
    use HasFactory, SoftDeletes, Loggable;

    protected $fillable = [
        'user_id',
        'notification_preference',
        'is_subscribed',
        'default_billing_address_id',
        'default_shipping_address_id',
        'discount_group_id',
    ];

    protected $appends = ['notification_preference_text'];

    public function getNotificationPreferenceTextAttribute()
    {
        return ucfirst($this->notification_preference);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function default_billing_address()
    {
        return $this->belongsTo(UserAddress::class,'default_billing_address_id');
    }

    public function default_shipping_address()
    {
        return $this->belongsTo(UserAddress::class,'default_shipping_address_id');
    }
}
