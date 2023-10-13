<?php

namespace App\Http\Controllers\Front\Cms\PopUp;

use App\Http\Controllers\Controller;
use App\Services\Cms\Popup\PopupService;

class PopUpController extends Controller
{
    protected $popUpService;

    public function __construct(PopupService $popupService){
        $this->popUpService = $popupService;
    }

    public function index(){
        $popUp = $this->popUpService->getPopUp();
        if($popUp){
            return response(['status' => "OK",'popup'=>$popUp], 200);
        }
        return response(['status' => 'ERROR', 'errors' => 'Problem occurred.'], 500);
    }
}
