<?php

namespace App\Http\Resources\Auth\Role;

use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $resource =[
            "id"=>$this->id,
            "name"=>$this->name,
            "name_text"=> ucwords($this->name),
            "guard_name"=>$this->guard_name
        ];
        return $resource;

    }
}
