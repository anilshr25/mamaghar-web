<?php

namespace App\Http\Controllers\Front\Cms\Inquery;

use App\Http\Controllers\Controller;
use App\Services\Cms\Inquery\InqueryService;
use Illuminate\Http\Request;

class InqueryController extends Controller
{
    protected $inqueryService;

    public function __construct(InqueryService $inqueryService){
        $this->inqueryService = $inqueryService;
    }

    public function store(Request $request){
        $requestData = $request->all();
        $requestData['is_replied'] = "false";
        $requestData['status'] = false;
        $inquery = $this->inqueryService->store($requestData);
        if($inquery){
            return redirect()->route('front.contact')->with('success', 'Inquery created successfully.');
        }
        return redirect()->route('front.contact')->with('Failed', 'Task Failed.');
    }
}

