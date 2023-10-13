<?php

namespace App\Http\Resources\EmailTemplate;

use Illuminate\Http\Resources\Json\JsonResource;

class EmailTemplateResource extends JsonResource
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
            'title' => $this->title,
            'subject' => $this->subject,
            'description' => $this->description,
            'type' => $this->type,
            'accepted_inputs' => $this->accepted_inputs,
            'is_active' => $this->is_active,
            'role' => $this->role,
            'status' => getBadgeByStatus($this->is_active),
        ];
        return $resource;
    }
}
