<?php

namespace App\Models\SiteSetting;

use App\Services\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SiteSetting extends Model
{
    use HasFactory, SoftDeletes, Loggable;

    protected $fillable = [
        'phone',
        'email',
        'website',
        'address',
        'map_url',
        'zoom_link',
        'copy_right_text',
        'facebook',
        'twitter',
        'youtube',
        'instagram',
        'linkedin',
        'tiktok',
        'pinterest',
        'viber',
        'whatsapp',
        'tagline',
        'payment_gateways',
        'fav_icon',
        'logo',
        'app_logo',
        'email_logo_image',
        'footer_logo',
        'storage_url',
        'storage_type',
        'storage_access_key',
        'storage_secret_key',
        'storage_region',
        'storage_endpoint',
        'storage_bucket_name',
        'facebook_chat_widgets',
        'google_analytics',
        'slogan',
        'login_bg_image',
        'login_bg_color',
        'primary_color',
        'secondary_color',
        'colors_variables',
        'recaptcha_site_key',
        'recaptcha_secret_key',
        'mail_driver',
        'mail_host',
        'mail_port',
        'mail_user_name',
        'mail_password',
        'mail_encryption',
        'mail_sender_name',
        'mail_sender_address',
        'date_format',
        'tax_percentage',
        'pan_no',
        'vat_no',
    ];

    protected $appends = [
        'fav_icon_path', 'app_logo_path', 'logo_path', 'login_bg_path', 'footer_logo_path', 'fb_chat_json_values', 'email_logo_path'
    ];

    public function getFbChatJsonValuesAttribute()
    {
        return json_decode($this->facebook_chat_widgets, true);
    }

    public function getColorsVariablesJsonValuesAttribute()
    {
        return json_decode($this->colors_variables, true);
    }

    public function getFavIconPathAttribute()
    {
        $imagePath = [];
        if (!empty($this->fav_icon)) {
            $imagePath = getFilePath('setting/fav-icon', $this->fav_icon);
        }
        return $imagePath;
    }

    public function getLogoPathAttribute()
    {
        $imagePath = [];
        if (!empty($this->logo)) {
            $imagePath = getFilePath('setting/logo', $this->logo);
        }
        return $imagePath;
    }

    public function getEmailLogoPathAttribute()
    {
        $imagePath = [];
        if (!empty($this->email_logo_image)) {

            $imagePath = getFilePath('setting/email-logo', $this->email_logo_image);
        }
        return $imagePath;
    }

    public function getFooterLogoPathAttribute()
    {
        $imagePath = [];
        if (!empty($this->footer_logo)) {

            $imagePath = getFilePath('setting/footer-logo', $this->footer_logo);
        }
        return $imagePath;
    }

    public function getAppLogoPathAttribute()
    {
        $imagePath = [];
        if (!empty($this->app_logo)) {
            $imagePath = getFilePath('setting/app-logo', $this->app_logo);
        }
        return $imagePath;
    }


    public function getLoginBgPathAttribute()
    {
        $imagePath = [];
        if (!empty($this->login_bg_image)) {

            $imagePath = getFilePath('setting/login-image', $this->login_bg_image);
        }
        return $imagePath;
    }
}
