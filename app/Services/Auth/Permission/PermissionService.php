<?php

namespace App\Services\Auth\Permission;

use App\Http\Resources\Auth\Permission\PermissionResource;
use App\Http\Resources\User\UserResource;
use App\Services\Auth\Role\RoleService;
use Spatie\Permission\Models\Permission;

class PermissionService
{
    protected $role;
    protected $permission;

    public function __construct(RoleService $role, Permission $permission)
    {
        $this->role = $role;
        $this->permission = $permission;
    }

    public function paginate($limit = 25)
    {
        $this->permission = $this->permission->orderBy('id', "DESC")->paginate($limit);
        return PermissionResource::collection($this->permission);
    }

    public function all()
    {
        $role = $this->permission->orderBy('name')->get();
        return PermissionResource::collection($role);
    }


    public function store($data)
    {
       try {
        $data['guard_name'] = "api";
        return $this->permission->create($data);
       } catch
       (\Exception $ex) {
           return false;
       }
    }

    public function find($id)
    {
        $this->permission = $this->permission->find($id);
        return new UserResource($this->permission);
    }

    public function update($id, $data)
    {
       try {
        $this->permission = $this->find($id);
        if (isset($data['type'])) {
            $data['type'] = sizeof($data['type']) > 0 ? implode(',', $data['type']) : null;
        }
        return $this->permission->update($data);
       } catch (\Exception $ex) {
           return false;
       }
    }

    public function delete($id)
    {
        try {
            $this->permission = $this->find($id);
            return $this->permission->delete();
        } catch (\Exception $ex) {
            return false;
        }
    }

    public function findByColumn($column, $value)
    {
        return $this->permission->where($column, $value)->first();
    }

    public function findByColumns($data, $all = false)
    {
        $response = $this->permission->where(function ($query) use ($data) {
            if (sizeof($data) > 0) {
                foreach ($data as $k => $v) {
                    $query->where($k, $data[$k]);
                }
            }
        });
        if ($all) {
            return PermissionResource::collection($response->get());
        } else {
            $response = $response->first();
            if (empty($response))
                return null;
            return new PermissionResource($response);
        }
    }

    public function findByWhereIn($column, $value, $data = [], $pluck = null, $all=false)
    {
        $permissions = $this->permission->whereIn($column, $value)->where(function ($qry) use ($data) {
            if (sizeof($data) > 0) {
                foreach ($data as $k => $d) {
                    $qry->where($k, $data[$k]);
                }
            }
        });
        $response = null;
        if ($all && empty($pluck))
            $response = $permissions->get();
        else if ($pluck)
            $response = $permissions->pluck($pluck)->all();
        else
            $response = $permissions->first();
        return $response;
    }

    public function permissionByGroup()
    {
        $permissionList = config('permission-role.user-role')['permissions'];
        $data = [];
        $list = [];
        foreach ($permissionList as $permission) {
            $temp = $this->permission->whereIn('name', $this->buildPermissionArray($permission))->pluck('name')->all();
            $list = array_merge($list, $temp);
            $permission = ucwords(str_replace('-', ' ', $permission));
            $data[$permission] = $temp;
        }
        $otherPermissionList = $this->permission->whereNotIn('name', $list)->pluck('name')->all();
        $data["Other"] = $otherPermissionList;
        return [
            "total_permissions" => $this->permission->count(),
            "permission_list" => $data,
        ];
    }

    public function buildPermissionArray($title)
    {
        $array = [];
        $action = ["list", 'create', 'show', 'edit', 'delete'];
        foreach ($action as $a) {
            $array[] = $title . "-" . $a;
        }
        return $array;
    }

}
