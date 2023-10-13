<?php

namespace App\Http\Resources\Room;

use Illuminate\Http\Resources\Json\JsonResource;

class RoomResource extends JsonResource
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
            'category_id' => $this->category_id,
            'category' => $this->category->title ?? null,
            'image' => $this->image,
            'image_path' => $this->image_path,
            'price' => $this->price,
            'room_number' => $this->room_number,
            'adult_number' => $this->adult_number,
            'kid_number' => $this->kid_number,
            'description' => $this->description,
            'is_active' => $this->is_active,
            'status' => getBadgeByStatus($this->is_active),
        ];
        return $resource;
    }
}
