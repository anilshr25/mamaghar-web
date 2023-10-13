<?php

namespace App\Services\Restaurant;

use App\Http\Resources\Restaurant\RestaurantResource;
use App\Models\Restaurant\Restaurant;
use App\Services\Image\ImageService;
use App\Services\Traits\UploadPathTrait;
use Exception;

class RestaurantService extends ImageService
{
    use UploadPathTrait;

    protected $restaurant;
    protected $uploadPath = "restaurant";

    public function __construct(Restaurant $restaurant)
    {
        $this->restaurant = $restaurant;
    }

    public function paginate($limit = 20, $request)
    {
        $restaurants = $this->restaurant->where(function ($query) use ($request) {

            if ($request->filled('title'))
                $query->where('title', 'like', '%' . $request->title . '%');

            if ($request->filled('category_id')) {
                $query->whereCategroyId($request->category_id);
            }

            if ($request->filled('is_active')) {
                $query->whereIsActive($request->is_active);
            }
        })->orderBy('id', 'DESC')->paginate($limit);

        return RestaurantResource::collection($restaurants);
    }

    public function find($id, $resource = true)
    {
        $restaurant = $this->restaurant->find($id);
        return $resource ? new RestaurantResource($restaurant) :  $restaurant;
    }

    public function getAllActive(){
        $restaurant = $this->restaurant->whereIsActive(1)->get();
        return RestaurantResource::collection($restaurant);
    }

    public function store($data)
    {
        try{
            if (!empty($data['image_file'])) {
                $data['image'] = $this->uploadFile($data['image_file'], $this->uploadPath, $data['title']);
            }
            return $this->restaurant->create($data);
        }
        catch(Exception $e)
        {
            return false;
        }
    }

    public function update($data, $id)
    {
        try{
            $restaurant = $this->find($id);
            if (!empty($data['image_file'])) {
                if (!empty($restaurant->image)) {
                    $this->deleteUploaded($restaurant->image, $this->uploadPath, $restaurant->title);
                }
                $data['image'] = $this->uploadFile($data['image_file'], $this->uploadPath, $restaurant->title);
            }
            return $restaurant->update($data);
        }
        catch(Exception $e)
        {
            return false;
        }
    }

    public function delete($id)
    {
        try{
            $restaurant = $this->find($id);
            if (!empty($restaurant->image)) {
                $this->deleteUploaded($restaurant->image, $this->uploadPath, $restaurant->title);
            }
            return $restaurant->delete($id);
        }
        catch(Exception $e)
        {
            return false;
        }
    }
}
