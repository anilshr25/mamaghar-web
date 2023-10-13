<?php

namespace App\Services\AdminUser;

use App\Http\Resources\AdminUser\AdminUserResource;
use App\Models\AdminUser\AdminUser;
use App\Models\RolePermission\UserCustomRolePermission;
use App\Services\Image\ImageService;
use Exception;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminUserService extends ImageService
{
    protected $adminUser;

    public function __construct(AdminUser $adminUser)
    {
        $this->adminUser = $adminUser;
    }

    public function paginate($request, $userId)
    {
        $adminUser = $this->adminUser->where(function ($query) use ($request) {

            if ($request->filled('first_name'))
                $query->where('first_name', 'like', '%' . $request->first_name . '%');

            if ($request->filled('is_active')) {
                $query->whereIsActive($request->is_active);
            }

        })->orderBy('id', "DESC");

        if ($userId) {
            $adminUser = $adminUser->whereNot('id', $userId);
        }

        if ($request->filled('limit')) {
           $adminUser = $adminUser->paginate($request->limit);
        } else {
            $adminUser = $adminUser->paginate(20);
        }

        return AdminUserResource::collection($adminUser);
    }

    public function find($id)
    {
        $adminUser = $this->adminUser->find($id);
        return $adminUser;
    }

    public function store($data)
    {
        try {
            $data['unique_identifier'] = $this->generateUniqueIidentifier();
            if (isset($data['imageFile']) && $data['imageFile'] != "undefined") {
                $data['image'] = $this->uploadFile($data['imageFile'], 'admin-user', $data['unique_identifier']);
            }
            if (isset($data['password'])){
                $data['password'] = bcrypt($data['password']);
            }
            return $this->adminUser->create($data);
        } catch (\Exception $ex) {
            return false;
        }
    }

    public function update($data, $id)
    {
        try {
            $adminUser = $this->find($id);
            if ($data['user_type'] == 'admin') {
                if(!empty($adminUser->image)){
                    $this->deleteUploaded($adminUser->file, 'admin-user', $adminUser->unique_identifier, true);
                }
                if (isset($data['imageFile']) && $data['imageFile'] != "undefined") {
                    $data['image'] = $this->uploadFile($data['imageFile'], 'admin-user', $data['unique_identifier']);
                }
            }
            else{
                if(!empty($adminUser->image)){
                    $this->deleteUploaded($adminUser->file, 'staff', $adminUser->unique_identifier, true);
                }
                if (isset($data['imageFile']) && $data['imageFile'] != "undefined") {
                    $data['image'] = $this->uploadFile($data['imageFile'], 'staff', $data['unique_identifier']);
                }
            }
            if (isset($data['password'])) $data['password'] = bcrypt($data['password']);
            return $adminUser->update($data);
        } catch (\Exception $ex) {
            return false;
        }
    }

    public function delete($id)
    {
        try {
            $adminUser = $this->find($id);
            return $adminUser->delete($id);
        } catch (Exception $e) {
            return false;
        }
    }

    public function getUserForLogin($email, $password)
    {
        $user = $this->adminUser->whereEmail($email)->first();
        if (empty($user) || !$user->is_active) {
            return false;
        }

        if (Hash::check($password, $user->password)) {
            return $user;
        }
    }

    public function findByColumn($column, $value)
    {
        return $this->adminUser->where($column, $value)->first();
    }

    public function findByColumns($data = [], $all = true, $resource = true, $limit = 0)
    {
        $result = $this->adminUser->where(function ($query) use ($data) {
            foreach ($data as $key => $value) {
                $query->where($key, $data[$key]);
            }
        });
        if ($limit > 0)
            $result = $result->take($limit);
        if ($all) {
            $result = $result->get();
            if ($resource)
                return AdminUserResource::collection($result);
            return $result;
        } else {
            $result = $result->first();
            if ($result)
                return new AdminUserResource($result);
            return $result;
        }
    }

    public function userRoles($userId)
    {
        try {
            $user = $this->findByColumn('id', $userId);
            return $user->roles->pluck('name')->all();
        } catch (\Exception $exception) {
            return false;
        }
    }


    public function assignRole($userId, $roles)
    {
        try {
            $user = $this->findByColumn('id', $userId);
            if ($user->syncRoles($roles)) {
                $data['type'] = sizeof($roles) > 0 ? implode(",", $roles) : null;
                $user->update($data);
            }
            return true;
        } catch (\Exception $exception) {
            return false;
        }
    }

    public function giveSubmenuPermissionToAdmin($userId)
    {
        $submenus = Config::get('permission-role.sub-menu-permission');
        $user = AdminUser::find($userId);
        $role = Role::where('name', 'admin')->first();
        if (sizeof($submenus) <= 0)
            return;
        foreach ($submenus as $key => $submenu) {
            foreach ($submenu as $sub) {
                $data = [
                    "admin_user_id" => $user->id,
                    "role_id" => $role->id,
                    "group_name" => $key,
                    "permission_name" => $sub,
                ];
                $userCustomRolePermission = UserCustomRolePermission::where(function ($qry) use ($data) {
                    foreach ($data as $key => $datum) {
                        $qry->where($key, $data[$key]);
                    }
                })->first();
                if (empty($userCustomRolePermission))
                    UserCustomRolePermission::create($data);
            }
        }
        Artisan::call('manage:custom-role-permission');
    }

    public function removeRole($userId, $roles)
    {
        try {
            $user = $this->findByColumn('id', $userId);
            return $user->removeRole([$roles]);
        } catch (\Exception $exception) {
            return false;
        }
    }

    public function generateUniqueIidentifier(){
        try {
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

        } catch (\Exception $ex) {
            return false;
        }
    }

    public function findByUniqueIidentifier($adminUser){
        $adminUser = $this->adminUser->whereUniqueIdentifier($adminUser)->first();
        if (!empty($adminUser))
            return $adminUser;
        return false;
    }

    public function randomNumber(){
        $random_number = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTVWXYZ"), 0, 6);
        return  $random_number;
    }
}
?>
