<?php

namespace App\Http\Resources\Cms\NewsAndUpdates;

use Illuminate\Http\Resources\Json\JsonResource;

class NewsAndUpdatesResource extends JsonResource
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
            'url' => $this->url,
            'published_by' => $this->published_by,
            'publish_date' => $this->publish_date,
            'formatted_publish_date' => $this->publish_date ? formatDate($this->publish_date) : null,
            'social_share_image' => $this->social_share_image,
            'social_share_image_path' => $this->social_share_image_path,
            'is_active' => $this->is_active ? true : false,
            'status' => getBadgeByStatus($this->is_active),
        ];
        return $resource;
    }
}
