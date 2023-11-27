<?php

namespace App\Http\Resources\SiteSetting;

use Illuminate\Http\Resources\Json\JsonResource;

class SiteSettingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $displayStorage = [
            !empty($this->storage_type),
            !empty($this->storage_access_key),
            !empty($this->storage_secret_key),
            !empty($this->storage_region),
            !empty($this->storage_bucket_name)
        ];
        $displaySmtpSetting = [
            !empty($this->mail_driver),
            !empty($this->mail_host),
            !empty($this->mail_port),
            !empty($this->mail_user_name),
            !empty($this->mail_password),
            !empty($this->mail_sender_name),
            !empty($this->mail_sender_address)
        ];
        $resource = [
            'id' => $this->id,
            'phone' => $this->phone,
            'email' => $this->email,
            'website' => $this->website,
            'address' => $this->address,
            'map_url' => $this->map_url,
            'zoom_link' => $this->zoom_link,
            'copy_right_text' => $this->copy_right_text,
            'cookie_consent_text' => $this->cookie_consent_text,
            'terms_condition' => $this->terms_condition,
            'facebook' => $this->facebook,
            'twitter' => $this->twitter,
            'youtube' => $this->youtube,
            'instagram' => $this->instagram,
            'linkedin' => $this->linkedin,
            'tiktok' => $this->tiktok,
            'pinterest' => $this->pinterest,
            'viber' => $this->viber,
            'whatsapp' => $this->whatsapp,
            'tagline' => $this->tagline,
            'payment_gateways' => $this->payment_gateways ? explode(',', $this->payment_gateways) : [],
            'fav_icon' => $this->fav_icon,
            'logo' => $this->logo,
            'enable_cookies' => $this->enable_cookies,
            'app_logo' => $this->app_logo,
            'slogan' => $this->slogan,
            'login_bg_image' => $this->login_bg_image,
            'login_bg_color' => $this->login_bg_color,
            'primary_color' => $this->primary_color,
            'secondary_color' => $this->secondary_color,
            'colors_variables' => $this->colors_variables,
            'date_format' => $this->date_format,
            'tax_percentage' => $this->tax_percentage,
            'pan_no' => $this->pan_no,
            'vat_no' => $this->vat_no,
            'address_type' => $this->address_type,
            'fav_icon_path' => $this->fav_icon_path,
            'app_logo_path' => $this->app_logo_path,
            'logo_path' => $this->logo_path,
            'login_bg_path' => $this->login_bg_path,
            'footer_logo_path' => $this->footer_logo_path,
            'display_storage' => in_array(false, $displayStorage) ? false : true,
            'display_smtp_setting' => in_array(false, $displaySmtpSetting) ? false : true,
            'email_logo_image' => $this->email_logo_image,
            'email_logo_path' => $this->email_logo_path,
        ];

        return $resource;
    }
}
