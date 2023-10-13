<?php

namespace App\Http\Resources\User\Address;

use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $resource = [
            'id' => $this->id,
            'user' => $this->user,
            'address_line_1' => ucwords($this->address_line_1),
            'address_line_2' => $this->address_line_2 ? ucwords($this->address_line_2) : '--',
            'area' => $this->area ? ucwords($this->area) : '--',
            'city' => $this->city ? ucwords($this->city) : '--',
            'post_code' => $this->post_code ? $this->post_code : '--',
            'province' => $this->province ? ucwords($this->province) : '--',
            'is_active' => $this->is_active,
            'status' => getBadgeByStatus($this->is_active),
        ];
        return $resource;
    }
}
