<?php

namespace App\Http\Resources\Cms\Popup;

use Illuminate\Http\Resources\Json\JsonResource;

class PopupResource extends JsonResource
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
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'type' => $this->type,
            'link_url' => $this->link_url,
            'file_path' => $this->file_path,
            'position'=>$this->position,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'is_active' => $this->is_active ? true : false,
            'status' => getBadgeByStatus($this->is_active),

        ];
        return $resource;
    }
}
