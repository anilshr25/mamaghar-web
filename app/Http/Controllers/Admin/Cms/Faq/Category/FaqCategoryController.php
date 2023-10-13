<?php

namespace App\Http\Controllers\Admin\Cms\Faq\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cms\Faq\Category\FaqCategoryRequest;
use App\Services\Cms\Faq\Category\FaqCategoryService;
use Illuminate\Http\Request;

class FaqCategoryController extends Controller
{
    protected $faqCategory;

    public function __construct(FaqCategoryService $faqCategory)
    {
        $this->faqCategory = $faqCategory;
    }

    public function index(Request $request)
    {
        return $this->faqCategory->paginate(25, $request);
    }

    public function all()
    {
        return $this->faqCategory->all();
    }

    public function sort(Request $request)
    {
        if ($this->faqCategory->sort($request->all())) {
            return response(['status' => "OK",], 200);
        }
        return response(['status' => 'ERROR', 'errors' => 'Problem occurred.'], 500);
    }

    public function store(FaqCategoryRequest $request)
    {
        $faqCategory = $this->faqCategory->store($request->all());
        if ($faqCategory)
            return response(['status' => "OK"], 200);
        return response(['status' => "ERROR"], 500);
    }

    public function show($id)
    {
        if ($faqCategory = $this->faqCategory->find($id))
            return response(['status' => "OK", 'faqCategory' => $faqCategory], 200);
        return response(['status' => "ERROR"], 500);
    }

    public function update(FaqCategoryRequest $request, $id)
    {
        $faqCategory = $this->faqCategory->update($request->all(), $id);
        if ($faqCategory)
            return response(['status' => "OK"], 200);
        return response(['status' => "ERROR"], 500);
    }

    public function destroy($id)
    {
        if ($this->faqCategory->delete($id))
            return response(['status' => "OK"], 200);
        return response(['status' => "ERROR"], 500);
    }
}
