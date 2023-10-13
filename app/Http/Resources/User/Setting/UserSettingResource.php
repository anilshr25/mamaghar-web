<?php

namespace App\Http\Resources\User\Setting;

use Illuminate\Http\Resources\Json\JsonResource;

class UserSettingResource extends JsonResource
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
            'user_id' => $this->user_id,
            'notification_preference' => $this->notification_preference,
            'is_subscribed' => $this->is_subscribed,
            'default_billing_address_id' => $this->default_billing_address_id,
            'default_shipping_address_id' => $this->default_shipping_address_id,
            'discount_group_id' => $this->discount_group_id,
        ];

       return $resource;
    }
}
