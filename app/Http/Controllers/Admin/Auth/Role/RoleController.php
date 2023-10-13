<?php


namespace App\Http\Controllers\Admin\Auth\Role;

use App\Http\Controllers\Controller;
use App\Jobs\User\Role\RebootPermissionJob;
use App\Services\Auth\Permission\PermissionService;
use App\Services\Auth\Role\RoleService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RoleController extends Controller
{

    protected $role;
    protected $permission;

    public function __construct(
        RoleService $role,
        PermissionService $permission
    )
    {
        $this->role = $role;
        $this->permission = $permission;
    }

    public function assignPermission(Request $request, $roleId)
    {
        if ($this->role->assignPermission($roleId, $request->get('permissions'))) {
            return response()->json(true);
        }
        return response()->json(false);
    }

    public function removePermission(Request $request, $roleId)
    {
        if ($this->role->removePermission($roleId, $request->get('permissions')))
            return response()->json(true);
        return response()->json(false);
    }

    public function rolePermissions($roleId)
    {
        return $this->role->rolePermission($roleId);
    }


    public function index(Request $request)
    {
        return $this->role->all($request);
    }

    public function store(Request $request)
    {
        $role = $this->role->store($request->all());
        if ($role)
            return response(['status' => "OK"], 200);
        return response(['status' => 'ERROR'], 500);
    }

    public function update(Request $request, $id)
    {
        $role = $this->role->update($id, $request->all());
        if ($role)
            return response(['status' => "OK"], 200);
        return response(['status' => 'ERROR'], 500);
    }

    public function destroy($id)
    {
        if ($this->role->delete($id))
            return response(['status' => "OK"], 200);
        return response(['status' => 'ERROR'], 500);
    }


    public function show($id)
    {
        if ($role = $this->role->find($id))
            return response(['status' => "OK", 'role' => $role], 200);
        return response(['status' => 'ERROR'], 500);
    }


    public function assignDefaultPermissions($roleId)
    {
        $role = $this->role->findByColumn('id', $roleId);
        if (!empty($role)) {
            $name = $role->name;
            $permissions = $permissions = config('permission-role.role-permission')[$name];
            $permissionIds = $this->permission->findByWhereIn('name', $permissions, [], 'id', false);
            if ($role->syncPermissions($permissionIds)) {
                dispatch(new RebootPermissionJob())->delay(Carbon::now()->addSeconds(5));
                return response(['status' => 'OK'], 200);
            }
            return response(['status' => 'ERROR'], 500);
        }
        return response(['status' => 'No role found'], 200);
    }


}
