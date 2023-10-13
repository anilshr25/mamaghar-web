<?php

namespace App\Http\Resources\AdminUser;

use Illuminate\Http\Resources\Json\JsonResource;

class AdminUserResource extends JsonResource
{
    public function toArray($request)
    {
        $resource = [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'full_name' => $this->full_name,
            'symbol_label' => $this->symbol_label,
            'email' => $this->email,
            'unique_identifier' => $this->unique_identifier,
            'image' => $this->image,
            'address_line_1' => $this->address_line_1,
            'address_line_2' => $this->address_line_2,
            'full_address' => $this->full_address,
            'mobile_no' => $this->mobile_no,
            'is_mfa_enabled'=>$this->is_mfa_enabled,
            'is_email_authentication_enabled'=>$this->is_email_authentication_enabled,
            'user_type' => ucwords($this->user_type),
            'is_active' => $this->is_active,
            'status' => getBadgeByStatus($this->is_active),
            'image_path' => $this->image_path
        ];
        return $resource;
    }
}
