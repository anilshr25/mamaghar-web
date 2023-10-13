<?php

namespace App\Http\Controllers\Front\Cms\Notice;

use App\Http\Controllers\Controller;
use App\Services\Cms\Notice\NoticeService;

class NoticeController extends Controller
{
    protected $noticeService;
    public function __construct(NoticeService $noticeService){
        $this->noticeService = $noticeService;
    }

    public function index(){
        $notice = $this->noticeService->getNotice();
        if($notice){
            return response(['status'=>'OK','notice'=>$notice],200);
        }
        return response(['status' => 'ERROR', 'errors' => 'Problem occurred.'], 500);
    }
}
