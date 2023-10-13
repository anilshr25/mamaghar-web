<?php


namespace App\Http\Controllers\Admin\Auth\CustomRoleAndPermission;

use App\Jobs\User\Role\RebootPermissionJob;
use App\Services\Auth\UserCustomRoleAndPermissionService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class UserCustomRoleAndPermissionController
{
    protected $permission;

    public function __construct(UserCustomRoleAndPermissionService $permission)
    {
        $this->permission = $permission;
    }

    public function getSubmenuPermissions()
    {
        $submenus = Config::get('permission-role.sub-menu-permission');
        return $submenus;
    }

    public function activateCommand()
    {
        dispatch(new RebootPermissionJob())->delay(Carbon::now()->addSeconds(5));
        return true;

    }

    public function savePermissions(Request $request)
    {
        $response = $this->permission->savePermissions($request->all());
        if ($response) {
            dispatch(new RebootPermissionJob())->delay(Carbon::now()->addSeconds(5));
            return response(['status' => "OK"], 200);
        }
        return response(['status' => "ERRORS"], 500);
    }

    public function getUserPermissionList()
    {
        $user = auth()->user()->id;
        $perpermissionList = $this->permission->getAllUserPermissionList($user);
        if ($perpermissionList)
            return response(['status' => "OK", 'permissions' => $perpermissionList], 200);
        return response(['status' => "ERRORS"], 500);
    }

    public function assignedPermissionToRole($role)
    {
        $response = $this->permission->assignedPermissionToRole($role);
        if ($response)
            return response(['status' => "OK", 'permissions' => $response], 200);
        return response(['status' => "ERRORS"], 500);
    }
}
