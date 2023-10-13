<?php


namespace App\Http\Controllers\Admin\Auth\Permission;


use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserRequest;
use App\Services\Auth\Permission\PermissionService;
use Illuminate\Http\Request;

class PermissionController extends Controller
{

    protected $permission;

    public function __construct(PermissionService $permission)
    {
        $this->permission = $permission;
    }


    public function index()
    {
        return $this->permission->paginate();
    }

    public function permissionByGroup()
    {
        return response($this->permission->permissionByGroup());
    }

    public function getAll()
    {
        return $this->permission->all();
    }

    public function store(Request $request)
    {
        $permission = $this->permission->store($request->all());
        if ($permission)
            return response(['status' => "OK"], 200);
        return response(['status' => 'ERROR'], 500);
    }

    public function update(Request $request, $id)
    {
        $permission = $this->permission->update($id, $request->all());
        if ($permission)
            return response(['status' => "OK"], 200);
        return response(['status' => 'ERROR'], 500);
    }

    public function destroy($id)
    {
        if ($this->permission->delete($id))
            return response(['status' => "OK"], 200);
        return response(['status' => 'ERROR'], 500);
    }


    public function show($id)
    {
        if ($permission = $this->permission->find($id))
            return response(['status' => "OK" ,'permission' => $permission], 200);
        return response(['status' => 'ERROR'], 500);
    }
}
