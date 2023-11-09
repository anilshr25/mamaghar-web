<?php

namespace App\Http\Controllers\Front\Index;

use App\Http\Controllers\Controller;
use App\Services\Room\RoomService;
use App\Services\Restaurant\RestaurantService;
use App\Services\Adventure\AdventureService;
use App\Services\Cms\Blog\BlogService;
use App\Services\SiteSetting\SiteSettingService;
use App\Services\Cms\Slider\SliderService;
use App\Services\Cms\Faq\FaqService;
use App\Services\Cms\Media\MediaService;
use App\Services\Room\Category\RoomCategoryService;
use App\Services\Service\ServiceService;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    protected $room;
    protected $media;
    protected $roomCategory;
    protected $restaurant;
    protected $blog;
    protected $setting;
    protected $slider;
    protected $faq;
    protected $adventure;
    protected $service;

    public function __construct (
        RoomService $room,
        RoomCategoryService $roomCategory,
        RestaurantService $restaurant,
        AdventureService $adventure,
        BlogService $blog,
        SiteSettingService $setting,
        SliderService $slider,
        FaqService $faq,
        MediaService $media,
        ServiceService $service
    )

    {
        $this->room = $room;
        $this->roomCategory = $roomCategory;
        $this->restaurant = $restaurant;
        $this->adventure = $adventure;
        $this->blog = $blog;
        $this->setting = $setting;
        $this->slider = $slider;
        $this->faq = $faq;
        $this->media = $media;
        $this->service = $service;
    }

    public function index()
    {
        $rooms = $this->room->getAllActive();
        $sliders = $this->slider->getFrontSlider();
        $medias = $this->media->all();
        $services = $this->service->getAllActive();
        return view('front.index', compact('rooms','sliders', 'medias', 'services'));
    }
    public function room()
    {
        $rooms = $this->room->getAllActive();
        return view('front.room.room', compact('rooms'));
    }

    public function roomDetails($slug)
    {
        $roomCategories = $this->roomCategory->allFront();
        $rooms = $this->room->paginateFront(2);
        $room = $this->room->getBySlug($slug);
        return view('front.room.details', compact('roomCategories', 'rooms', 'room'));
    }

    public function restaurant()
    {
        $restaurants = $this->restaurant->getAllActive();
        return view('front.restaurant.restaurant', compact('restaurants'));
    }

    public function adventure (){
        $adventures = $this->adventure->getAllActive();
        return view('front.adventure.adventure', compact('adventures'));

    }

    public function service (){
        $services = $this->service->getAllActive();
        return view('front.service.service', compact('services'));
    }


    public function faq()
    {
        $faqs = $this->faq->getAllActive();
        return view('front.faq.faq', compact('faqs'));
    }

    public function blog (){
        $blogs = $this->blog->getAllActive();
        return view('front.blog.blog', compact('blogs'));
    }

    public function contact (){
        $settings = $this->setting->getSetting();
        return view('front.contact.contact');
    }
    public function about (){

        return view('front.about.about');
    }


}
