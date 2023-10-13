<?php

namespace App\Http\Controllers\Admin\Adventure\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\Adventure\Category\AdventureCategoryRequest;
use App\Services\Adventure\Gallery\Category\AdventureCategoryService;
use Illuminate\Http\Request;

class AdventureCategoryController extends Controller
{
    protected $adventureCategory;

    public function __construct(AdventureCategoryService $adventureCategory)
    {
        $this->adventureCategory = $adventureCategory;
    }

    public function index(Request $request)
    {
        return $this->adventureCategory->paginate(10, $request);
    }

    public function getAllCategory()
    {
        return $this->adventureCategory->getAllCategory();
    }

    public function store(AdventureCategoryRequest $request)
    {
        $adventureCategory = $this->adventureCategory->store($request->all());
        if($adventureCategory)
            return response(['status' => "OK"], 200);
        return response(['status' =>"ERROR"], 500);
    }

    public function show($id)
    {
        if($adventureCategory = $this->adventureCategory->find($id))
            return response(['status' => "OK", 'adventureCategory' => $adventureCategory], 200);
        return response(['status' => "ERROR"], 500);
    }

    public function update(AdventureCategoryRequest $request, $id)
    {
        $adventureCategory = $this->adventureCategory->update($request->all(), $id);
        if($adventureCategory)
            return response(['status' => "OK"], 200);
        return response(['status' => "ERROR"], 500);
    }

    public function destroy($id)
    {
        if($this->adventureCategory->delete($id))
            return response(['status' => "OK"], 200);
        return response(['status' => "ERROR"], 500);
    }
}
