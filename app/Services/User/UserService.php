<?php

namespace App\Services\User;

use App\Http\Resources\User\UserResource;
use App\Models\User\User;
use App\Services\Image\ImageService;
use Exception;
use Illuminate\Support\Facades\Hash;

class UserService extends ImageService
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function paginate($limit = 25, $request)
    {
        $users = $this->user->where(function ($query) use ($request) {

            if ($request->filled('title'))
                $query->where('title', 'like', '%' . $request->title . '%');

            if ($request->filled('category_id')) {
                $query->whereCategroyId($request->category_id);
            }

            if ($request->filled('is_active')) {
                $query->whereIsActive($request->is_active);
            }
        })->orderBy('id', 'DESC')->paginate($limit);

        return UserResource::collection($users);
    }

    public function find($id)
    {
        $user = $this->user->find($id);
        return new UserResource($user);
    }

    public function store($data)
    {
        try {
            $data['unique_identifier'] = $this->generateUniqueIidentifier();
            if (isset($data['image_file']) && $data['image_file'] != "undefined") {
                $data['image'] = $this->uploadFile($data['image_file'], 'users', $data['unique_identifier']);
            }
            $data['password'] = isset($data['password']) ? $data['password'] = bcrypt($data['password']) : null;
            $data['is_active'] = isset($data['is_active']) && $data['is_active'] == 'true' ? 1 : 0;
            return $this->user->create($data);
        } catch (Exception $e) {
            return false;
        }
    }

    public function register($data)
    {
        try {
            if (isset($data['image']) && $data['image'] != "undefined") {
                $data['image'] = $this->uploadFile($data['image'], 'users', $data['name']);
            }
            $data['password'] = isset($data['password']) ? $data['password'] = bcrypt($data['password']) : null;
            $data['unique_identifier'] = $this->generateUniqueIidentifier();
            $data['is_login_verified'] = 0;
            $data['is_active'] = 0;
            return $this->user->create($data);
        } catch (Exception $e) {
            return false;
        }
    }

    public function update($data, $id)
    {
        try {
            $user = $this->find($id);
            if (isset($data['imageFile']) && $data['imageFile'] != "undefined") {
                $data['image'] = $this->uploadFile($data['imageFile'], 'users', $user->unique_identifier);
            }
            // if ($user->is_mfa_enabled == 1 && isset($data['is_mfa_enabled']) && $data['is_mfa_enabled'] == 0) {
            //     $data['mfa_secret_code'] = null;
            //     $data['mfa_authentication_image'] = null;
            //     MFADisableJob::dispatch($user);
            // }
            // if ($user->is_email_authentication_enabled== 1 && isset($data['is_email_authentication_enabled']) && $data['is_email_authentication_enabled'] == 0) {
            //     EmailVerificationDisableJob::dispatch($user);
            // }
            return $user->update($data);
        } catch (Exception $e) {
            return false;
        }
    }

    public function delete($id)
    {
        try {
            $user = $this->find($id);
            return $user->delete($id);
        } catch (Exception $e) {
            return false;
        }
    }

    public function getUserForLogin($email, $password)
    {
        $user = $this->user->whereEmail($email)->orWhere('mobile_no', $email)->first();

        if (empty($user)) {
            return false;
        }

        if (Hash::check($password, $user->password)) {
            return $user;
        }

    }

    public function findByColumn($column, $value)
    {
        return $this->user->where($column, $value)->first();
    }

    public function findByColumns($data = null, $all = true, $resource = true, $limit = 0)
    {
        $result = $this->user->where(function ($query) use ($data) {
            foreach ($data as $key => $value) {
                $query->where($key, $data[$key]);
            }
        });
        if ($limit > 0)
            $result = $result->take($limit);
        if ($all) {
            $result = $result->get();
            if ($resource)
                return UserResource::collection($result);
            return $result;
        } else {
            $result = $result->first();
            if ($result)
                return new UserResource($result);
            return $result;
        }
    }

    public function generatePassword($id)
    {
        $user = $this->find($id);
        $password = generateRandomPassword();
        $data['password'] = bcrypt($password);
        $user->update($data);
        // ResetPasswordJob::dispatch($user, $password);
    }

    public function searchUser($request)
    {
        $users = $this->user->whereType('retailer')->whereIsActive(1)->where(function ($query) use ($request) {
            $query->where('first_name', 'LIKE', "%$request->info%")
                   ->orWhere('last_name', 'LIKE', "%$request->info%")
                   ->orWhere('unique_identifier', 'LIKE', "%$request->info%")
                   ->orWhere('email', 'LIKE', "%$request->info%");
        })->take(10)->get();
        return UserResource::collection($users);
    }

    public function findByUniqueIidentifier($user){
        $user = $this->user->whereUniqueIdentifier($user)->first();
        if (!empty($user))
            return $user;
        return false;
    }

    public function generateUniqueIidentifier(){

        $random_number=$this->randomNumber();
        if ($random_number)
            while (true){
                $uniqueNumber = $this->findByUniqueIidentifier($random_number);
                if(!$uniqueNumber){
                    return $random_number;
                }else{
                    $random_number=$this->randomNumber();
                }
            }

    }

    public function randomNumber(){
        $random_number = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTVWXYZ"), 0, 6);
        return  $random_number;
    }
}
