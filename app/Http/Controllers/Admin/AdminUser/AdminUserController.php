<?php

namespace App\Http\Controllers\Admin\AdminUser;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminUser\AdminUserRequest;
use App\Jobs\Admin\AdminUserAccountCreatedJob;
use App\Jobs\User\Role\RebootPermissionJob;
use App\Services\AdminUser\AdminUserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class AdminUserController extends Controller
{
protected $adminUser;

    public function __construct(AdminUserService $adminUser)
    {
        $this->adminUser = $adminUser;
    }

    public function index(Request $request)
    {
        return $this->adminUser->paginate($request, auth()->guard('admin')->user()->id);
    }

    public function store(AdminUserRequest $request)
    {
        $adminUser = $this->adminUser->store($request->all());
        if($adminUser) {
            AdminUserAccountCreatedJob::dispatch($adminUser);
            return response(['status' => "OK"], 200);
        }

        return response(['status' =>"ERROR"], 500);
    }

    public function show($id)
    {
        if($adminUser = $this->adminUser->find($id))
            return response(['status' => "OK", 'adminUser' => $adminUser ], 200);
        return response(['status' => "ERROR"], 500);
    }

    public function update(Request $request, $id)
    {
        $adminUser = $this->adminUser->update($request->all(), $id);
        if($adminUser)
            return response(['status' => "OK"], 200);
        return response(['status' => "ERROR"], 500);
    }

    public function destroy($id)
    {
        if($this->adminUser->delete($id))
            return response(['status' => "OK"], 200);
        return response(['status' => "ERROR"], 500);
    }

    public function hasRoles($userId, $roles)
    {
        try {
            $user = $this->findByColumn('id', $userId);
            return $user->hasRoles($roles);
        } catch (\Exception $exception) {
            return false;
        }
    }

    public function userRoles($userId)
    {
        if ($userRoles = $this->adminUser->userRoles($userId))
            return response($userRoles);
        return response()->json(false);
    }

    public function assignRole(Request $request, $userId)
    {
        $roles = $request->get( 'roles');
        if ($this->adminUser->assignRole($userId, $request->get('roles'))) {
            if (in_array('admin', $roles)) {
                $this->adminUser->giveSubmenuPermissionToAdmin($userId);
            } else
                Artisan::call('manage:custom-role-permission');
            return response()->json(true);
        }
        return response()->json(false);
    }

    public function removeRole(Request $request, $userId)
    {
        if ($this->adminUser->removeRole($userId, $request->get('roles')))
            return response()->json(true);
        return response()->json(false);
    }
}
