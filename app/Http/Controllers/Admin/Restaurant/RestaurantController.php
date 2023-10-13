<?php

namespace App\Http\Controllers\Admin\Restaurant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Restaurant\RestaurantRequest;
use App\Services\Restaurant\RestaurantService;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    protected $restaurant;

    public function __construct(RestaurantService $restaurant)
    {
        $this->restaurant = $restaurant;
    }

    public function index(Request $request)
    {
        return $this->restaurant->paginate(10, $request);
    }

    public function store(RestaurantRequest $request)
    {
        $restaurant = $this->restaurant->store($request->all());
        if($restaurant)
            return response(['status' => "OK"], 200);
        return response(['status' =>"ERROR"], 500);
    }

    public function show($id)
    {
        if($restaurant = $this->restaurant->find($id))
            return response(['status' => "OK", 'restaurant' => $restaurant], 200);
        return response(['status' => "ERROR"], 500);
    }

    public function update(RestaurantRequest $request, $id)
    {
        $restaurant = $this->restaurant->update($request->all(), $id);
        if($restaurant)
            return response(['status' => "OK"], 200);
        return response(['status' => "ERROR"], 500);
    }

    public function destroy($id)
    {
        if($this->restaurant->delete($id))
            return response(['status' => "OK"], 200);
        return response(['status' => "ERROR"], 500);
    }
}
