<?php

namespace App\Http\Resources\Cms\Blog;

use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
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
            'publish_date' => $this->publish_date,
            'blog_type' => $this->blog_type,
            'category_id' => array_map('intval', explode(',', $this->category_id)),
            'categories' => $this->categories ?? [],
            'image' => $this->image,
            'image_path' => $this->image_path,
            'video_url' => $this->video_url,
            'author_name' => $this->author_name,
            'author_image' => $this->author_image,
            'author_image_path' => $this->author_image_path,
            'seo_title' => $this->seo_title,
            'seo_keyword' => $this->seo_keyword,
            'description' => $this->description,
            'is_active' => $this->is_active ? true : false,
            'status' => getBadgeByStatus($this->is_active),
        ];

        return $resource;
    }
}
