<?php

namespace App\Http\Resources\SiteSetting;

use Illuminate\Http\Resources\Json\JsonResource;

class ColorSettingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $resource = [
            'id' => $this->id,
            'primary_color' => $this->primary_color,
            'secondary_color' => $this->secondary_color,
            'colors_variables' => $this->colors_variables,
            'colors_variables_json_values' => $this->colors_variables_json_values,
        ];
        return $resource;
    }
}
