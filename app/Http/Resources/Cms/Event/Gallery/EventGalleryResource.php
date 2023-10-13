<?php

namespace App\Http\Resources\Cms\Event\Gallery;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventGalleryResource extends JsonResource
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
            'even_id' => $this->even_id,
            'type' => $this->type,
            'position' => $this->position,
            'file' => $this->file,
            'file_path' => $this->file_path,
            'is_active' => $this->is_active,
            'status' => getBadgeByStatus($this->is_active),
        ];

        return $resource;
    }
}
