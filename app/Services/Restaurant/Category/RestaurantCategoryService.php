<?php

namespace App\Services\Restaurant\Category;

use App\Http\Resources\Restaurant\Category\RestaurantCategoryResource;
use App\Models\Restaurant\Category\RestaurantCategory;
use Exception;

class RestaurantCategoryService
{
    protected $restaurantCategory;

    public function __construct(RestaurantCategory $restaurantCategory)
    {
        $this->restaurantCategory = $restaurantCategory;
    }

    public function paginate($limit, $request)
    {
        $restaurantCategories = $this->restaurantCategory->where(function ($query) use ($request) {

            if ($request->filled('title')) {
                $query->where('title', 'like', '%' . $request->title . '%');
            }

            if ($request->filled('is_active')) {
                $query->whereIsActive($request->is_active);
            }
        })->orderBy('id', 'DESC');

        $restaurantCategories = $restaurantCategories->paginate($limit);

        return RestaurantCategoryResource::collection($restaurantCategories);
    }

    public function getAllCategory(){
        $restaurantCategories = $this->restaurantCategory->whereIsActive(1)->get();
        return RestaurantCategoryResource::collection($restaurantCategories);
    }

    public function find($id)
    {
        $restaurantCategory = $this->restaurantCategory->find($id);
        return new RestaurantCategoryResource($restaurantCategory);
    }

    public function store($data)
    {
        try{
            return $this->restaurantCategory->create($data);
        }
        catch(Exception $e)
        {
            return false;
        }
    }

    public function update($data, $id)
    {
        try{
            $restaurantCategory = $this->find($id);
            return $restaurantCategory->update($data);
        }
        catch(Exception $e)
        {
            return false;
        }
    }

    public function delete($id)
    {
        try{
            $restaurantCategory = $this->find($id);
            return $restaurantCategory->delete($id);
        }
        catch(Exception $e)
        {
            return false;
        }
    }
}
