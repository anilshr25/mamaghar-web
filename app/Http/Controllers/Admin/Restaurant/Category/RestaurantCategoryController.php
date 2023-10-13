<?php

namespace App\Http\Controllers\Admin\Restaurant\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\Restaurant\Category\RestaurantCategoryRequest;
use App\Services\Restaurant\Category\RestaurantCategoryService;
use Illuminate\Http\Request;

class RestaurantCategoryController extends Controller
{
    protected $restaurantCategory;

    public function __construct(RestaurantCategoryService $restaurantCategory)
    {
        $this->restaurantCategory = $restaurantCategory;
    }

    public function index(Request $request)
    {
        return $this->restaurantCategory->paginate(20, $request);
    }

    public function getAllCategory()
    {
        return $this->restaurantCategory->getAllCategory();
    }

    public function store(RestaurantCategoryRequest $request)
    {
        $restaurantCategory = $this->restaurantCategory->store($request->all());
        if($restaurantCategory)
            return response(['status' => "OK"], 200);
        return response(['status' =>"ERROR"], 500);
    }

    public function show($id)
    {
        if($restaurantCategory = $this->restaurantCategory->find($id))
            return response(['status' => "OK", 'restaurantCategory' => $restaurantCategory], 200);
        return response(['status' => "ERROR"], 500);
    }

    public function update(RestaurantCategoryRequest $request, $id)
    {
        $restaurantCategory = $this->restaurantCategory->update($request->all(), $id);
        if($restaurantCategory)
            return response(['status' => "OK"], 200);
        return response(['status' => "ERROR"], 500);
    }

    public function destroy($id)
    {
        if($this->restaurantCategory->delete($id))
            return response(['status' => "OK"], 200);
        return response(['status' => "ERROR"], 500);
    }
}

