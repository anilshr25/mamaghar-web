<?php

namespace App\Http\Controllers\Admin\User\Setting;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\Setting\UserSettingResource;
use App\Services\User\Setting\UserSettingService;
use App\Services\User\UserService;
use Illuminate\Http\Request;

class UserSettingController extends Controller
{
    protected $userSetting;
    protected $user;
    protected $newsletter;
    protected $setting;

    public function __construct(UserSettingService $userSetting, UserService $user)
    {
        $this->userSetting=$userSetting;
        $this->user=$user;
    }

    public function store(Request $request)
    {
        $userSetting=$this->userSetting->createOrUpdate($request->all());
        if ($userSetting) {
            return response(['status' => "OK"], 200);
        }
        return response(['errors'=>'Problem occurred.'], 500);
    }

    public function createOrUpdate(Request $request)
    {
        $userSetting=$this->userSetting->createOrUpdate($request->all());
        if ($userSetting) {
            return response(['status' => "OK"], 200);
        }
        return response(['errors'=>'Problem occurred.'], 500);
    }

    public function update(Request $request, $id)
    {
        $userSetting = $this->userSetting->update($id, $request->all());
        if ($userSetting)
            return response(['status' => "OK"], 200);

        return response(['status' =>  "ERROR",'errors'=>'Problem occurred.'], 200);
    }

    public function getSettingByUserId($userId)
    {
        if(empty($this->userSetting->getByUserId($userId))){
            $user = $this->user->find($userId);
            if($user){
                $data =  [];
                $data['user_id'] = $userId;
                $data['notification_preference'] = 'email';
                $data['is_subscribed'] = 0;
                $this->userSetting->createOrUpdate($data);
            }
        }
        if ($userSetting = $this->userSetting->getByUserId($userId))
            return response(['status' => "OK", 'userSetting' => new UserSettingResource($userSetting)], 200);
        return response(['status' => 'ERROR'], 500);
    }
}
