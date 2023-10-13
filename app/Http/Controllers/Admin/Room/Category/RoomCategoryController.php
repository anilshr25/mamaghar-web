<?php

namespace App\Http\Controllers\Admin\Room\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\Room\Category\RoomCategoryRequest;
use App\Services\Room\Category\RoomCategoryService;
use Illuminate\Http\Request;

class RoomCategoryController extends Controller
{
    protected $roomCategory;

    public function __construct(RoomCategoryService $roomCategory)
    {
        $this->roomCategory = $roomCategory;
    }

    public function index(Request $request)
    {
        return $this->roomCategory->paginate(20, $request);
    }

    public function getAllCategory()
    {
        return $this->roomCategory->getAllCategory();
    }

    public function store(RoomCategoryRequest $request)
    {
        $roomCategory = $this->roomCategory->store($request->all());
        if($roomCategory)
            return response(['status' => "OK"], 200);
        return response(['status' =>"ERROR"], 500);
    }

    public function show($id)
    {
        if($roomCategory = $this->roomCategory->find($id))
            return response(['status' => "OK", 'roomCategory' => $roomCategory], 200);
        return response(['status' => "ERROR"], 500);
    }

    public function update(RoomCategoryRequest $request, $id)
    {
        $roomCategory = $this->roomCategory->update($request->all(), $id);
        if($roomCategory)
            return response(['status' => "OK"], 200);
        return response(['status' => "ERROR"], 500);
    }

    public function destroy($id)
    {
        if($this->roomCategory->delete($id))
            return response(['status' => "OK"], 200);
        return response(['status' => "ERROR"], 500);
    }
}

