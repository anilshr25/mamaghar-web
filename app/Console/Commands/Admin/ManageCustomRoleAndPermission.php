<?php

namespace App\Console\Commands\Admin;

use App\Models\AdminUser\AdminUser;
use App\Models\RolePermission\UserCustomRolePermission;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ManageCustomRoleAndPermission extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'manage:custom-role-permission';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Manage Custom Role And Permission';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if ($this->assignToAdmin() && $this->createRoleAndPermissionByUser()) {
            $this->removeRoleAndPermissionOfUser();
        }
    }

    public function createRoleAndPermissionByUser()
    {
        $users = AdminUser::whereIsActive(1)->get();
        $entryIds = [];
        foreach ($users as $user) {
            $roles = $user->getRoleNames();
            if (sizeof($roles)) {
                foreach ($roles as $role) {
                    $role = Role::where('name', $role)->first();
                    $rolePermissionCount = $role->permissions->count();
                    $permissionNames = $role->permissions->pluck('name');
                    $permissionIds = $role->permissions->pluck('id');
                    for ($i = 0; $i < $rolePermissionCount; $i++) {
                        $data = [];
                        $data = [
                            "admin_user_id" => $user->id,
                            "role_id" => $role->id,
                            "group_name" => $this->getGroupName($permissionNames[$i]),
                            "permission_id" => $permissionIds[$i],
                            "permission_name" => $permissionNames[$i],
                        ];
                        $userCustomRolePermission = UserCustomRolePermission::where(function ($qry) use ($data) {
                            foreach ($data as $key => $value) {
                                $qry->where($key, $data[$key]);
                            }
                        })->first();
                        if (empty($userCustomRolePermission)) {
                            $userCustomRolePermission = UserCustomRolePermission::create($data);
                            array_push($entryIds, $userCustomRolePermission->id);
                        } else {
                            array_push($entryIds, $userCustomRolePermission->id);
                        }
                    }
                }
            }
        }
        return true;
    }

    public function removeRoleAndPermissionOfUser()
    {
        $adminUsers = AdminUser::whereIsActive(0)->pluck('id')->all();
        foreach ($adminUsers as $user) {
           UserCustomRolePermission::whereAdminUserId($user)->delete();
        }
    }

    public function getGroupName($permission)
    {
        $actions = ["list", 'edit', 'create', 'delete', 'show'];
        foreach ($actions as $action) {
            if (str_contains($permission, $action)) {
                return explode('-' . $action, $permission)[0];
            }
        }
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
                return true;
            }
        } catch (\Exception $exception) {
            return false;
        }
    }
}
