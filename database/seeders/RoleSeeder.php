<?php

namespace Database\Seeders;

use App\Models\AdminUser\AdminUser;
use App\Models\RolePermission\UserCustomRolePermission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
        $roles = Config::get('permission-role.user-role')['roles'];
        foreach ($roles as $r => $role) {
            $rr = Role::where('name', $role)->orWhere('guard_name', $role)->first();
            if (empty($rr)) {
                $data = [
                    "name" => $role,
                    "guard_name" => 'admin'
                ];
                Role::create($data);
            }
        }

        $permissions = Config::get('permission-role.user-role')['permissions'];
        if (sizeof($permissions) <= 0)
            return;
        foreach ($permissions as $r => $permission) {
            $permissionsArray = $this->generatePermissions($permission);
            foreach ($permissionsArray as $arr) {
                $rr = Permission::where('name', $arr)->orWhere('guard_name', $arr)->first();
                if (empty($rr)) {
                    $data = [
                        "name" => $arr,
                        "guard_name" => 'admin'
                    ];
                    Permission::create($data);
                }
            }
            // $otherPermission = ['import-export', 'except_resource'];
            // foreach ($otherPermission as $p) {
            //     $rr = Permission::where('name', $p)->first();
            //     if (empty($rr)) {
            //         Permission::create(["name" => $p, "guard_name" => "admin"]);
            //     }
            // }
        }
        $this->assignToAdmin();
        $this->giveSubmenuPermissionToAdmin();
    }

    public function generatePermissions($permission)
    {
        $array = [];
        $action = ["list", 'edit', 'create', 'delete', 'show'];
        foreach ($action as $a => $act) {
            array_push($array, $permission . '-' . $act);
        }
        return $array;
    }

    public function assignToAdmin()
    {
        try {
            $user = AdminUser::find(1);
            if (!empty($user)) {
                $role = Role::whereName('admin')->first();
                $permissions = Permission::where("guard_name", "admin")->pluck('id')->all();
                $role->syncPermissions($permissions);
                $user->assignRole([$role->name]);
            }
        } catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }

    public function giveSubmenuPermissionToAdmin()
    {
        $submenus = Config::get('permission-role.sub-menu-permission');
        $user = AdminUser::find(1);
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
                    foreach ($data as $key => $value) {
                        $qry->where($key, $data[$key]);
                    }
                })->first();
                if (empty($userCustomRolePermission))
                    UserCustomRolePermission::create($data);
            }
        }
        Artisan::call('manage:custom-role-permission');
    }
}
