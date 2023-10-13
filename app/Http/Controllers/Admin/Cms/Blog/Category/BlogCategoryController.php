<?php

namespace App\Http\Controllers\Admin\Cms\Blog\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cms\Blog\Category\BlogCategoryRequest;
use App\Services\Cms\Blog\Category\BlogCategoryService;
use Illuminate\Http\Request;

class BlogCategoryController extends Controller
{
    protected $blogCategory;

    public function __construct(BlogCategoryService $blogCategory)
    {
        $this->blogCategory = $blogCategory;
    }

    public function index(Request $request)
    {
        return $this->blogCategory->paginate(25, $request);
    }

    public function getAllActive()
    {
        return $this->blogCategory->getAllActive();
    }

    public function store(BlogCategoryRequest $request)
    {
        if ($this->blogCategory->store($request->all())) {
            return response(['status' => "OK",], 200);
        }
        return response(['status' => 'ERROR'], 200);
    }

    public function show($id)
    {
        if ($blogCategory = $this->blogCategory->find($id))
            return response(['status' => "OK", 'blogCategory' => $blogCategory], 200);
        return response(['status' => "ERROR"], 500);
    }

    public function update(Request $request, $id)
    {
        $blogCategory = $this->blogCategory->update($id, $request->all());
        if ($blogCategory)
            return response(['status' => "OK"], 200);
        return response(['status' => "ERROR"], 500);
    }


    public function destroy($id)
    {
        if ($this->blogCategory->delete($id))
            return response(['status' => "OK"], 200);
        return response(['status' => "ERROR"], 500);
    }
}
