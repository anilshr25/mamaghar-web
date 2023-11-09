<?php

namespace App\Http\Controllers\Admin\SiteSetting;

use App\Http\Controllers\Controller;
use App\Services\SiteSetting\SiteSettingService;
use Illuminate\Http\Request;

class SiteSettingController extends Controller
{
    protected $setting;

    public function __construct(SiteSettingService $setting)
    {
        $this->setting = $setting;
    }

    public function index()
    {
        return response(['data' => $this->setting->getSetting()]);
    }

    public function getSettingColors()
    {
        return response(['data' => $this->setting->getSettingColors()]);
    }

    public function createOrUpdate(Request $request)
    {
        $setting = $this->setting->createOrUpdate($request->all());
        if ($setting)
            return response(['status' => "OK"], 200);
        return response(['status' => 'ERROR'], 500);
    }

    public function testAwsUpload(Request $request)
    {
        $file = $request->file('image');
        $response = $this->setting->testAwsUpload($file);
        if ($response)
            return response(['status' => "OK", 'path' => $response], 200);
        return response(['status' => 'ERROR'], 500);
    }

    public function sendTestEmail(Request $request)
    {
        $email = $request->get('email');
        $response = $this->setting->sendTestEmail($email);
        if ($response)
            return response(['status' => "OK"], 200);
        return response(['status' => 'ERROR'], 500);
    }
}
