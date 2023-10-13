<?php

namespace App\Http\Controllers\Front\Cms\Faq\Category;

use App\Http\Controllers\Controller;
use App\Services\Cms\Faq\FaqService;
use App\Services\Cms\Faq\Category\FaqCategoryService;

class FaqCategoryController extends Controller
{
    protected $faqCategoryService,$faqService;
    public function __construct(FaqCategoryService $faqCategoryService, FaqService $faqService){
        $this->faqCategoryService = $faqCategoryService;
        $this->faqService = $faqService;
    }
    public function getFaqCategory(){
        $faqsCategory =$this->faqCategoryService->getFaqCategory();
        if($faqsCategory){
            return response(['status' => "OK",'faqs_category' => $faqsCategory], 200);
        }
        return response(['status' => 'ERROR', 'errors' => 'Problem occurred.'], 500);
    }
}
