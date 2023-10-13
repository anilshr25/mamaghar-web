<?php

namespace App\Http\Resources\SiteSetting\PaymentGatewaySetting;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentGatewaySettingResource extends JsonResource
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
            'type' => $this->type,
            'merchant_id' => $this->merchant_id,
            'public_key' => $this->public_key,
            'private_key' => $this->private_key,
            'bank_qr_code' => $this->bank_qr_code,
            'bank_qr_code_path' => $this->bank_qr_code_path,
            'description' => $this->description,
            'is_sandbox' => $this->is_sandbox ? true : false,
            'is_active' => $this->is_active ? true : false,
        ];
        return $resource;
    }
}
