<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $resource = [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'full_name' => $this->full_name,
            'email' => $this->email,
            'image' => $this->image,
            'image_path' => $this->image_path,
            'mobile_no' => $this->mobile_no,
            'type' => $this->type,
            'gender' => $this->gender,
            'is_active' => $this->is_active,
            'status' => getBadgeByStatus($this->is_active),
            'member_since' => formatDate($this->created_at),
            'is_login_verified' => $this->is_login_verified,
            'is_mfa_enabled' =>$this->is_mfa_enabled,
            'is_email_authentication_enabled' => $this->is_email_authentication_enabled,
        ];
        return $resource;
    }
}
