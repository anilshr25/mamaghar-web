<?php

namespace App\Services\User\Setting;

use App\Models\User\Setting\UserSetting;

class UserSettingService
{
    protected $userSetting;
    protected $uploadPath = 'uploads/users/setting';

    public function __construct(UserSetting $userSetting)
    {
        $this->userSetting=$userSetting;
    }

    public function store($data)
    {
        try {
            $userSetting = $this->userSetting->create($data);
            return $userSetting;
        } catch
        (\Exception $ex) {
            return false;
        }
    }
    public function find($userSettingId)
    {
        $userSetting = $this->userSetting->find($userSettingId);
        if (!empty($userSetting))
            return $userSetting;
        return null;

    }
    public function update($id, $data)
    {
        try {
            $userSetting = $this->find($id);
            $userSetting->update($data);
            return $userSetting;
        } catch (\Exception $ex) {
            return false;
        }
    }

    public function getByUserId($userId){
        $userSetting = $this->userSetting->whereUserId($userId)->first();

        if($userSetting)
             return $userSetting;
        return null;
    }

    function createOrUpdate($data)
    {
        try {
            if (!empty($data['user_id'])) {
                $user=$this->getByUserId($data['user_id']);
                if (empty($user))
                    $user = $this->store($data);
                else
                    $user = $this->update($user->id,$data);

                return $user;
            }
            return null;
        } catch (\Exception $ex) {
            return false;
        }
    }
}
