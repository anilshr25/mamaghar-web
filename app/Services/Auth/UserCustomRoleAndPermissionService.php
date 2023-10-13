<?php

namespace App\Services\Auth;

use App\Models\RolePermission\UserCustomRolePermission;
use Illuminate\Support\Facades\Config;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserCustomRoleAndPermissionService
{
    protected $customPermission;
    protected $permission;
    protected $role;

    public function __construct(UserCustomRolePermission $customPermission, Role $role, Permission $permission)
    {
        $this->customPermission = $customPermission;
        $this->role = $role;
        $this->permission = $permission;
    }

    public function savePermissions($data)
    {
        $entry = [];
        $role = $data['role'];
        $role = $this->role->whereName($role)->first();
        $permissions = $data['permissions'];
        foreach ($permissions as $permission) {
            $parent = $this->getParent($permission);
            if (!empty($parent)) {
                $users = $role->users->pluck('id');
                if (sizeof($users) > 0) {
                    foreach ($users as $user) {
                        $data = [
                            "admin_user_id" => $user,
                            "role_id" => $role->id,
                            "group_name" => $parent,
                            "permission_name" => $permission,
                        ];
                        $p = $this->customPermission->where(function ($q) use ($data) {
                            foreach ($data as $k => $datum) {
                                $q->where($k, $data[$k]);
                            }
                        })->first();
                        if (empty($p)) {
                            $savedPermission = $this->customPermission->create($data);
                            array_push($entry, $savedPermission->id);
                        } else {
                            array_push($entry, $p->id);
                        }
                    }

                    if (sizeof($entry)) {
                        $this->customPermission->whereNotIn('id', $entry)->delete();
                    }
                }
            }
        }
        return true;
    }

    public function getParent($value)
    {
        $submenus = Config::get('permission-role.sub-menu-permission');
        foreach ($submenus as $key => $menu) {
            $sub = $submenus[$key];
            if (in_array($value, $sub)) {
                return $key;
            }
        }
    }

    public function assignedPermissionToRole($roleId)
    {
        $list = $this->customPermission->distinct()->whereNull('permission_id')->whereRoleId($roleId)->pluck('permission_name')->all();
        return $list;
    }

    public function getAllUserPermissionList($userId)
    {
        $rolePermissions = Config::get('permission-role.user-role');
        $permissions = $rolePermissions['permissions'];
        $assignedPermission = [];
        if (sizeof($permissions)<=0)
            return ;
        foreach ($permissions as $permission) {
            $list = $this->customPermission->whereAdminUserId($userId)->whereGroupName($permission)->pluck('permission_name')->all();
            foreach ($list as $i => $l) {
                $actions = ["list", 'edit', 'create', 'delete', 'show'];
                foreach ($actions as $action) {
                    if (in_array($permission . "-" . $action, $list)) {
                        $list[$i] = str_replace($permission . "-", "", $l);
                    }
                }
            }
            $assignedPermission[$permission] = $list;

        }
        return $assignedPermission;

    }
}
