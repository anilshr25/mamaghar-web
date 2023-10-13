<?php

namespace App\Http\Controllers\Admin\Booking\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\Booking\Category\BookingCategoryRequest;
use App\Services\Booking\Category\BookingCategoryService;
use Illuminate\Http\Request;

class BookingCategoryController extends Controller
{
    protected $bookingCategory;

    public function __construct(BookingCategoryService $bookingCategory)
    {
        $this->bookingCategory = $bookingCategory;
    }

    public function index(Request $request)
    {
        return $this->bookingCategory->paginate(20, $request);
    }

    public function getAllCategory()
    {
        return $this->bookingCategory->getAllCategory();
    }

    public function store(BookingCategoryRequest $request)
    {
        $bookingCategory = $this->bookingCategory->store($request->all());
        if ($bookingCategory)
            return response(['status' => "OK"], 200);
        return response(['status' => "ERROR"], 500);
    }

    public function show($id)
    {
        if ($bookingCategory = $this->bookingCategory->find($id))
            return response(['status' => "OK", 'bookingCategory' => $bookingCategory], 200);
        return response(['status' => "ERROR"], 500);
    }

    public function update(BookingCategoryRequest $request, $id)
    {
        $bookingCategory = $this->bookingCategory->update($request->all(), $id);
        if ($bookingCategory)
            return response(['status' => "OK"], 200);
        return response(['status' => "ERROR"], 500);
    }

    public function destroy($id)
    {
        if ($this->bookingCategory->delete($id))
            return response(['status' => "OK"], 200);
        return response(['status' => "ERROR"], 500);
    }
}
