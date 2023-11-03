<?php

namespace App\Http\Resources\Adventure;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdventureResource extends JsonResource
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
            'title' => $this->title,
            'slug' => $this->slug,
            'image' => $this->image,
            'image_path' => $this->image_path,
            'category_id' => $this->category_id,
            'category' => $this->category->title ?? null,
            'description' => $this->description,
            'is_active' => $this->is_active ? true : false,
            'status' => getBadgeByStatus($this->is_active),
        ];

        return $resource;
    }
}
