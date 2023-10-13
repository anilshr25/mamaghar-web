<?php

namespace App\Http\Resources\Adventure\Gallery;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdventureGalleryResource extends JsonResource
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
            'file' => $this->file,
            'file_path' => $this->file_path,
            'description' => $this->description,
            'is_active' => $this->is_active,
            'status' => getBadgeByStatus($this->is_active),
        ];
        return $resource;
    }
}
