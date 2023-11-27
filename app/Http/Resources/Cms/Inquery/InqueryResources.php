<?php

namespace App\Http\Resources\Cms\Inquery;

use Illuminate\Http\Resources\Json\JsonResource;

class InqueryResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $resource = [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone_no' => $this->phone_no,
            'subject' => $this->subject,
            'message' => $this->message,
            'is_replied' => $this->is_replied,
            'is_active' => $this->is_active ? true : false,
            'status' => getBadgeByStatus($this->is_active),
        ];
        return $resource;
    }
}
