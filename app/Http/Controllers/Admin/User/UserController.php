<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserRequest;
use App\Services\User\Setting\UserSettingService;
use App\Services\User\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $user;
    protected $userSetting;

    public function __construct(UserService $user, UserSettingService $userSetting)
    {
        $this->user = $user;
        $this->userSetting = $userSetting;
    }

    public function index(Request $request)
    {
        return $this->user->paginate(20, $request);
    }

    public function store(UserRequest $request)
    {
        $user = $this->user->store($request->all());
        if($user) {
            if($user){
                $data = [];
                $data['user_id'] = $user->id;
                $data['notification_preference'] = 'email';
                $data['is_subscribed'] = 0;
                $this->userSetting->createOrUpdate($data);
            }
            return response(['status' => "OK"], 200);
        }
        return response(['status' =>"ERROR"], 500);
    }

    public function show($id)
    {
        if($user = $this->user->find($id))
            return response(['status' => "OK", 'user' => $user ], 200);
        return response(['status' => "ERROR"], 500);
    }

    public function update(Request $request, $id)
    {
        $user = $this->user->update($request->all(), $id);
        if($user)
            return response(['status' => "OK"], 200);
        return response(['status' => "ERROR"], 500);
    }

    public function destroy($id)
    {
        if($this->user->delete($id))
            return response(['status' => "OK"], 200);
        return response(['status' => "ERROR"], 500);
    }

    public function generatePassword($id){
        $password = $this->user->generatePassword($id);
        if ($password)
            return response(["status" => "OK", 'password' => $password], 200);
        return response(["status" => "ERROR"], 500);
    }

    public function searchUser(Request $request){
        $users = $this->user->searchUser($request);
        if ($users)
            return response(["status" => "OK", 'users' => $users], 200);
        return response(["status" => "ERROR"], 500);
    }

}
