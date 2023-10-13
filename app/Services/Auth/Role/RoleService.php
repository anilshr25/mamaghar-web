<?php

namespace App\Services\Auth\Role;

use App\Http\Resources\Auth\Role\RoleResource;
use Spatie\Permission\Models\Role;

class RoleService
{
    protected $role;

    public function __construct(Role $role)
    {
        $this->role = $role;
    }

    public function assignPermission($roleId, $permissions)
    {
    //    try {
        $role = $this->findByColumn('id', $roleId);
        return $role->syncPermissions($permissions);
    //    } catch (\Exception $exception) {
    //        return false;
    //    }
    }

    public function hasPermission($roleId, $permissions)
    {
        try {
            $role = $this->findByColumn('id', $roleId);
            return $role->hasPermission($permissions);
        } catch (\Exception $exception) {
            return false;
        }
    }

    public function removePermission($roleId, $permissions)
    {
        try {
            $role = $this->findByColumn('id', $roleId);
            return $role->revokePermissionTo($permissions);
        } catch (\Exception $exception) {
            return false;
        }
    }

    public function rolePermission($roleId)
    {
        // try {
            $role = $this->findByColumn('id', $roleId);
            return $role->permissions->pluck('name')->all();
        // } catch (\Exception $exception) {
        //     return false;
        // }
    }

    public function paginate($limit = 25)
    {
        $role = $this->role->orderBy('id', "DESC")->paginate($limit);
        return RoleResource::collection($role);
    }

    public function all($request)
    {
        $role = $this->role->orderBy('id', "DESC")->get();
        return RoleResource::collection($role);
    }

    public function store($data)
    {
        try {
            if (isset($data['type'])) {
                $data['type'] = sizeof($data['type']) > 0 ? implode(',', $data['type']) : null;
            }
            $data['password'] = bcrypt($data['password']);
            return $this->role->create($data);
        } catch
        (\Exception $ex) {
            return false;
        }
    }

    public function find($id)
    {
        $role = $this->role->find($id);
        return new RoleResource($role);
    }

    public function update($id, $data)
    {
       try {
        $role = $this->find($id);
        if (isset($data['type'])) {
            $data['type'] = sizeof($data['type']) > 0 ? implode(',', $data['type']) : null;
        }
        return $role->update($data);
       } catch (\Exception $ex) {
           return false;
       }
    }

    public function delete($id)
    {
        try {
            $role = $this->find($id);
            return $role->delete();
        } catch (\Exception $ex) {
            return false;
        }
    }

    public function findByColumn($column, $value)
    {
        return $this->role->where($column, $value)->first();
    }

    // public function getUserForLogin($email, $password)
    // {
    //     $role = $this->role->whereEmail($email)->first();
    //     if (empty($role))
    //         return false;

    //     if (Hash::check($password, $role->password))
    //         return $role;

    //     return false;
    // }

    // public function findByColumns($data, $all = false)
    // {
    //     $response = $this->role->where(function ($query) use ($data) {
    //         if (sizeof($data) > 0) {
    //             foreach ($data as $k => $v) {
    //                 $query->where($k, $data[$k]);
    //             }
    //         }
    //     });
    //     if ($all) {
    //         return RoleResource::collection($response->get());
    //     } else {
    //         $response = $response->first();
    //         if (empty($response))
    //             return null;
    //         return new RoleResource($response);
    //     }
    // }


}
