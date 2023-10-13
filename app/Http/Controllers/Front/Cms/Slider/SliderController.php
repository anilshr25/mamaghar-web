<?php

namespace App\Http\Controllers\Front\Cms\Slider;

use App\Http\Controllers\Controller;
use App\Services\Cms\Slider\SliderService;

class SliderController extends Controller
{
    public $slider;

    public function __construct(SliderService $slider)
    {
        $this->slider = $slider;
    }

    public function index()
    {
        return $this->slider->findByColumns(['is_active' => 1]);
    }

}
