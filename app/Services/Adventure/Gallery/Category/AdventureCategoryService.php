<?php

namespace App\Services\Adventure\Gallery\Category;

use App\Http\Resources\Adventure\Category\AdventureCategoryResource;
use App\Models\Adventure\Category\AdventureCategory;
use Exception;

class AdventureCategoryService
{
    protected $adventureCategory;

    public function __construct(AdventureCategory $adventureCategory)
    {
        $this->adventureCategory = $adventureCategory;
    }

    public function paginate($limit, $request)
    {
        $adventureCategories = $this->adventureCategory->where(function ($query) use ($request) {

            if ($request->filled('title')) {
                $query->where('title', 'like', '%' . $request->title . '%');
            }

            if ($request->filled('is_active')) {
                $query->whereIsActive($request->is_active);
            }
        })->orderBy('id', 'DESC');

        $adventureCategories = $adventureCategories->paginate($limit);

        return AdventureCategoryResource::collection($adventureCategories);
    }

    public function getAllCategory(){
        $adventureCategories = $this->adventureCategory->whereIsActive(1)->get();
        return AdventureCategoryResource::collection($adventureCategories);
    }

    public function find($id)
    {
        $adventureCategory = $this->adventureCategory->find($id);
        return new AdventureCategoryResource($adventureCategory);
    }

    public function store($data)
    {
        try{
            return $this->adventureCategory->create($data);
        }
        catch(Exception $e)
        {
            return false;
        }
    }

    public function update($data, $id)
    {
        try{
            $adventureCategory = $this->find($id);
            return $adventureCategory->update($data);
        }
        catch(Exception $e)
        {
            return false;
        }
    }

    public function delete($id)
    {
        try{
            $adventureCategory = $this->find($id);
            return $adventureCategory->delete($id);
        }
        catch(Exception $e)
        {
            return false;
        }
    }
}
