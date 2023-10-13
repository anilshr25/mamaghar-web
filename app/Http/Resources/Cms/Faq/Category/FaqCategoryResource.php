<?php

namespace App\Http\Resources\Cms\Faq\Category;

use App\Http\Resources\Cms\Faq\FaqResource;
use Illuminate\Http\Resources\Json\JsonResource;

class FaqCategoryResource extends JsonResource
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
            'description'=>$this->description,
            'slug' => $this->slug,
            'is_parent' => $this->is_parent,
            'parent_id' => $this->parent_id,
            'position' => $this->position,
            'is_active' => $this->is_active ? true : false,
            'status' => getBadgeByStatus($this->is_active),
        ];
        return $resource;
    }
}
