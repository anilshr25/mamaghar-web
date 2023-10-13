<?php

namespace App\Http\Resources\Cms\Slider;

use Illuminate\Http\Resources\Json\JsonResource;

class SliderResource extends JsonResource
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
            'heading_text' => $this->heading_text,
            'sub_heading_text' => $this->sub_heading_text,
            'description' => $this->description,
            'button_text' => $this->button_text,
            'show_button' => $this->show_button,
            'show_button' => $this->show_button ? true : false,
            'link' => $this->link,
            'image_path' => $this->image_path,
            'position' => $this->position,
            'new_tab' => $this->new_tab ? true : false,
            'is_active' => $this->is_active ? true : false,
            'status' => getBadgeByStatus($this->is_active),
        ];
        return $resource;
    }
}
