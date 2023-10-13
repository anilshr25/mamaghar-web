<?php

namespace App\Models\SiteSetting\PaymentGateway;

use App\Services\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentGatewaySetting extends Model
{
    use HasFactory , SoftDeletes, Loggable;

    protected $uploadPath = 'uploads/payment-gateway-setting';

    protected $fillable =[
        'type',
        'public_key',
        'private_key',
        'merchant_id',
        'bank_qr_code',
        'description',
        'is_active',

    ];

    protected $appends = ['bank_qr_code_path'];

    public function getBankQrCodePathAttribute()
    {
        if($this->bank_qr_code) {
            return getFilePath($this->uploadPath, $this->bank_qr_code);
        }
        return null;
    }
}
