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
        $setting = $this->getSetting();
        if ($setting)
            return $this->update($setting,$data);
        else
            return $this->store($data);
    }

    public function store($data)
    {
        if (!empty($data['logo_file'])) {
            $data['logo'] = $this->uploadFile($data['logo_file'], 'setting/logo');
        }

        if (!empty($data['app_logo_file'])) {
            $data['app_logo'] = $this->uploadFile($data['app_logo_file'], 'setting/app-logo');
        }

        if (!empty($data['fav_icon_file'])) {
            $data['fav_icon'] = $this->uploadFile($data['fav_icon_file'], 'setting/fav-icon');
        }

        if (!empty($data['login_bg_image_file'])) {
            $data['login_bg_image'] = $this->uploadFile($data['login_bg_image_file'], 'setting/login-image');
        }

        if (!empty($data['email_logo_image_file'])) {
            $data['email_logo_image'] = $this->uploadFile($data['email_logo_image_file'], 'setting/email-logo');
        }

        if (!empty($data['footer_logo_file'])) {
            $data['footer_logo'] = $this->uploadFile($data['footer_logo_file'], 'setting/footer-logo');
        }

        return $this->setting->create($data);
    }

    public function update($setting, $data)
    {
        if (!empty($data['logo_file'])) {
            if (!empty($setting->logo)) {
                $this->deleteUploaded($setting->logo, 'setting/logo');
            }
            $data['logo'] = $this->uploadFile($data['logo_file'], 'setting/logo');
        }

        if (!empty($data['app_logo_file'])) {
            if (!empty($setting->app_logo)) {
                $this->deleteUploaded($setting->app_logo, 'setting/app-logo');
            }
            $data['app_logo'] = $this->uploadFile($data['app_logo_file'], 'setting/app-logo');
        }

        if (!empty($data['fav_icon_file'])) {
            if (!empty($setting->fav_icon)) {
                $this->deleteUploaded($setting->fav_icon, 'setting/fav-icon');
            }
            $data['fav_icon'] = $this->uploadFile($data['fav_icon_file'], 'setting/fav-icon');
        }

        if (!empty($data['login_bg_image_file'])) {
            if (!empty($setting->login_bg_image)) {
                $this->deleteUploaded($setting->login_bg_image, 'setting/login-image');
            }
            $data['login_bg_image'] = $this->uploadFile($data['login_bg_image_file'], 'setting/login-image');
        }

        if (!empty($data['email_logo_image_file'])) {
            if (!empty($setting->email_logo_image)) {
                $this->deleteUploaded($setting->email_logo_image, 'setting/email-logo');
            }
            $data['email_logo_image'] = $this->uploadFile($data['email_logo_image_file'], 'setting/email-logo');
        }
        if (!empty($data['footer_logo_file'])) {
            if (!empty($setting->footer_logo)) {
                $this->deleteUploaded($setting->footer_logo, 'setting/footer-logo');
            }
            $data['footer_logo'] = $this->uploadFile($data['footer_logo_file'], 'setting/footer-logo');
        }

        return $setting->update($data);
    }

    public function testAwsUpload($file)
    {
        $uploadPath = 'site-setting';
        $data = $this->uploadFile($file, $uploadPath);
        $uploadPath = getUploadPath($uploadPath);
        $path = $uploadPath . "/" . $data;
        $url = s3_image_url($path, true);
        return $url;
    }

    public function sendTestEmail($email)
    {
        Mail::to($email)->send(new SMTPTestEmail());
        return true;
    }
}
