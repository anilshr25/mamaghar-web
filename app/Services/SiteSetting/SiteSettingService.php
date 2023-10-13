<?php

namespace App\Services\SiteSetting;

use App\Http\Resources\SiteSetting\ColorSettingResource;
use App\Http\Resources\SiteSetting\SiteSettingResource;
use App\Mail\Admin\SiteSetting\SMTPTestEmail;
use App\Models\SiteSetting\SiteSetting;
use App\Services\Image\ImageService;
use Illuminate\Support\Facades\Mail;

class SiteSettingService extends ImageService
{
    protected $setting;
    public $uploadPath = 'setting';

    public function __construct(SiteSetting $setting)
    {
        $this->setting = $setting;
    }

    public function getSetting()
    {
        $setting = $this->setting->first();

        if (!empty($setting))
            return new SiteSettingResource($setting);
        return null;
    }

    public function getSettingColors()
    {
        $setting = $this->setting->first();

        if (!empty($setting))
            return new ColorSettingResource($setting);
        return null;
    }

    public function createOrUpdate($data)
    {
        $data['is_active'] = (isset($data['is_active']) && $data['is_active'] == true) ? true : 0;
        if (!empty($data['logo_file'])) {
            $data['logo'] = $this->uploadFile($data['logo_file'], $this->uploadPath);
        }

        if (!empty($data['app_logo_file'])) {
            $data['app_logo'] = $this->uploadFile($data['app_logo_file'], $this->uploadPath);
        }

        if (!empty($data['fav_icon_file'])) {
            $data['fav_icon'] = $this->uploadFile($data['fav_icon_file'], $this->uploadPath);
        }

        if (!empty($data['login_bg_image_file'])) {
            $data['login_bg_image'] = $this->uploadFile($data['login_bg_image_file'], $this->uploadPath);
        }

        if (!empty($data['email_logo_image_file'])) {
            $data['email_logo_image'] = $this->uploadFile($data['email_logo_image_file'], $this->uploadPath);
        }
        if (!empty($data['footer_logo_file'])) {
            $data['footer_logo'] = $this->uploadFile($data['footer_logo_file'], $this->uploadPath);
        }
        $setting = $this->getSetting();
        if (isset($data['id']) && $setting)
            return $setting->update($data);
        else
            return $this->setting->create($data);
    }

    public function testAwsUpload($file)
    {
        $uploadPath = 'uploads/test';
        $data = $this->uploadFile($file, null, null, $uploadPath);
        $path = $uploadPath . "/" . $data;
        if (env('APP_ENV') != "production")
            $path = "local/" . $path;
        $url = s3_image_url($path);
        return $url;
    }

    public function sendTestEmail($email)
    {
        setSMTP();
        Mail::to($email)->send(new SMTPTestEmail());
        return true;
    }
}
