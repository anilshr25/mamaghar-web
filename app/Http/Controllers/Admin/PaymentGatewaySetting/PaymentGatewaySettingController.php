<?php

namespace App\Http\Controllers\Admin\PaymentGatewaySetting;

use App\Http\Controllers\Controller;
use App\Services\SiteSetting\PaymentGateway\PaymentGatewaySettingService;
use Illuminate\Http\Request;

class PaymentGatewaySettingController extends Controller
{
    protected $paymentGatewaySetting;

    public function __construct(PaymentGatewaySettingService $paymentGatewaySetting) {
        $this->paymentGatewaySetting = $paymentGatewaySetting;
    }

    public function index()
    {
        $bank = $this->paymentGatewaySetting->findByColumn('type', 'bank');
        $khati = $this->paymentGatewaySetting->findByColumn('type', 'khati');
        $esewa = $this->paymentGatewaySetting->findByColumn('type', 'esewa');
        $paypal = $this->paymentGatewaySetting->findByColumn('type', 'paypal');
        $stripe = $this->paymentGatewaySetting->findByColumn('type', 'stripe');
        return response([
            'bank' => $bank,
            'esewa' => $esewa,
            'khati' => $khati,
            'paypal' => $paypal,
            'stripe' => $stripe,
        ], 200);
    }

    public function store(Request $request)
    {
        $paymentGatewaySetting = $this->paymentGatewaySetting->store($request->all());
        if ($paymentGatewaySetting)
            return response(['status' => "OK"], 200);
        return response(['status' => "ERROR"], 500);
    }

    public function update($id, Request $request)
    {
        $paymentGatewaySetting = $this->paymentGatewaySetting->update($id, $request->all());
        if ($paymentGatewaySetting)
            return response(['status' => "OK"], 200);
        return response(['status' => "ERROR"], 500);
    }

}
