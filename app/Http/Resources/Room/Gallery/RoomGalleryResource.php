<?php

namespace App\Http\Resources\Room\Gallery;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoomGalleryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $resource = [
            'id' => $this->id,
            'room_id' => $this->room_id,
            'is_feature_image' => $this->is_feature_image,
            'file' => $this->file,
            'file_path' => $this->file_path,
            'description' => $this->description,
            'is_active' => $this->is_active,
            'status' => getBadgeByStatus($this->is_active),
        ];
        return $resource;
    }
}
