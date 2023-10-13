<?php

namespace App\Services\SiteSetting\PaymentGateway;

use App\Http\Resources\SiteSetting\PaymentGatewaySetting\PaymentGatewaySettingResource;
use App\Models\SiteSetting\PaymentGateway\PaymentGatewaySetting;
use App\Services\Image\ImageService;

class PaymentGatewaySettingService extends ImageService
{
    protected $paymentGatewaySetting;

    protected $uploadPath = 'payment-gateway-setting';

    public function __construct(PaymentGatewaySetting $paymentGatewaySetting)
    {
        $this->paymentGatewaySetting = $paymentGatewaySetting;
    }

    public function getAllPaymentGateway()
    {
        $paymentGatewaySetting = $this->paymentGatewaySetting->orderBy('type')->get();
        return PaymentGatewaySettingResource::collection($paymentGatewaySetting);
    }

    public function store($data)
    {
        try {
            $data['is_active'] = (isset($data['is_active']) && $data['is_active'] == true) ? true : 0;
            if (isset($data['bank_qr_code_file'])) {
                $data['bank_qr_code'] = $this->uploadFile($data['bank_qr_code_file'], $this->uploadPath);
            }
            return $this->paymentGatewaySetting->create($data);
        } catch (\Exception $ex) {
            return false;
        }
    }

    public function update($id, $data)
    {
        try {
            $paymentGatewaySetting = $this->findByColumn('id', $id);

            if (isset($data['bank_qr_code_file'])) {
                if (!empty($paymentGatewaySetting->author_image)) {
                    $this->deleteUploaded($paymentGatewaySetting->image, $this->uploadPath);
                }
                $data['bank_qr_code'] = $this->uploadFile($data['bank_qr_code_file'], $this->uploadPath);
            }
            return $paymentGatewaySetting->update($data);
        } catch (\Exception $ex) {
            return false;
        }
    }

    public function delete($id)
    {
        try {
            $paymentGatewaySetting = $this->findByColumn('id', $id);
            return $paymentGatewaySetting->delete();
        } catch (\Exception $ex) {
            return false;
        }
    }

    public function findByColumn($column, $value)
    {
        $paymentGatewaySetting = $this->paymentGatewaySetting->where($column, $value)->first();
        if (!empty($paymentGatewaySetting))
            return $paymentGatewaySetting ? new PaymentGatewaySettingResource($paymentGatewaySetting) : null;
        return null;
    }
}
