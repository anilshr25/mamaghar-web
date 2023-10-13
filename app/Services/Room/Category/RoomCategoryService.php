<?php

namespace App\Services\Room\Category;

use App\Http\Resources\Room\Category\RoomCategoryResource;
use App\Models\Room\Category\RoomCategory;
use Exception;

class RoomCategoryService
{
    protected $roomCategory;

    public function __construct(RoomCategory $roomCategory)
    {
        $this->roomCategory = $roomCategory;
    }

    public function paginate($limit, $request)
    {
        $roomCategories = $this->roomCategory->where(function ($query) use ($request) {

            if ($request->filled('title')) {
                $query->where('title', 'like', '%' . $request->title . '%');
            }

            if ($request->filled('is_active')) {
                $query->whereIsActive($request->is_active);
            }
        })->orderBy('id', 'DESC');

        $roomCategories = $roomCategories->paginate($limit);

        return RoomCategoryResource::collection($roomCategories);
    }

    public function getAllCategory()
    {
        $roomCategories = $this->roomCategory->whereIsActive(1)->get();
        return RoomCategoryResource::collection($roomCategories);
    }

    public function find($id)
    {
        $roomCategory = $this->roomCategory->find($id);
        return new RoomCategoryResource($roomCategory);
    }

    public function store($data)
    {
        try {
            return $this->roomCategory->create($data);
        } catch (Exception $e) {
            return false;
        }
    }

    public function update($data, $id)
    {
        try {
            $roomCategory = $this->find($id);
            return $roomCategory->update($data);
        } catch (Exception $e) {
            return false;
        }
    }

    public function delete($id)
    {
        try {
            $roomCategory = $this->find($id);
            return $roomCategory->delete($id);
        } catch (Exception $e) {
            return false;
        }
    }
    public function allFront(){
        return $this->roomCategory->whereIsActive(1)->get();
    }
}
