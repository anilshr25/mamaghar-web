<?php

namespace App\Http\Resources\Cms\Media;

use Illuminate\Http\Resources\Json\JsonResource;

class MediaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $resource = [
            "id" => $this->id,
            "position" => $this->position,
            "image" => $this->image,
            "type" => $this->type,
            "image_path" => $this->image_path
        ];

        return $resource;
    }
}
