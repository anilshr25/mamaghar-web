<?php

namespace App\Services\Booking\Category;

use App\Http\Resources\Booking\Category\BookingCategoryResource;
use App\Models\Booking\Category\BookingCategory;
use Exception;

class BookingCategoryService
{
    protected $bookingCategory;

    public function __construct(BookingCategory $bookingCategory)
    {
        $this->bookingCategory = $bookingCategory;
    }

    public function paginate($limit, $request)
    {
        $bookingCategories = $this->bookingCategory->where(function ($query) use ($request) {

            if ($request->filled('title')) {
                $query->where('title', 'like', '%' . $request->title . '%');
            }

            if ($request->filled('is_active')) {
                $query->whereIsActive($request->is_active);
            }
        })->orderBy('id', 'DESC');

        $bookingCategories = $bookingCategories->paginate($limit);

        return BookingCategoryResource::collection($bookingCategories);
    }

    public function getAllCategory()
    {
        $bookingCategories = $this->bookingCategory->whereIsActive(1)->get();
        return BookingCategoryResource::collection($bookingCategories);
    }

    public function find($id)
    {
        $bookingCategory = $this->bookingCategory->find($id);
        return new BookingCategoryResource($bookingCategory);
    }

    public function store($data)
    {
        try {
            return $this->bookingCategory->create($data);
        } catch (Exception $e) {
            return false;
        }
    }

    public function update($data, $id)
    {
        try {
            $bookingCategory = $this->find($id);
            return $bookingCategory->update($data);
        } catch (Exception $e) {
            return false;
        }
    }

    public function delete($id)
    {
        try {
            $bookingCategory = $this->find($id);
            return $bookingCategory->delete($id);
        } catch (Exception $e) {
            return false;
        }
    }
}
