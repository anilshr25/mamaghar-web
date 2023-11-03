<?php

namespace App\Http\Resources\Services;

use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
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
            'image' => $this->image,
            'image_path' => $this->image_path,
            'short_description' => $this->description,
            'is_feature' => $this->is_feature,
            'feature_status' => getBadgeByStatus($this->is_feature),
            'is_active' => $this->is_active ? true : false,
            'status' => getBadgeByStatus($this->is_active),
        ];
        return $resource;
    }
}
