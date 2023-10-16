<?php

namespace App\Services\Service;

use App\Http\Resources\Services\ServiceResource;
use App\Models\Service\Service;
use App\Services\Image\ImageService;
use App\Services\Traits\UploadPathTrait;
use Exception;

class ServiceService extends ImageService
{
    use UploadPathTrait;

    protected $service;
    protected $uploadPath = "service";

    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    public function paginate($limit = 20, $request)
    {
        $services = $this->service->where(function ($query) use ($request) {

            if ($request->filled('title'))
                $query->where('title', 'like', '%' . $request->title . '%');

            if ($request->filled('category_id')) {
                $query->whereCategroyId($request->category_id);
            }

            if ($request->filled('is_active')) {
                $query->whereIsActive($request->is_active);
            }
        })->orderBy('id', 'DESC');

        $services = $services->paginate($limit);

        return ServiceResource::collection($services);
    }

    public function find($id, $resource = true)
    {
        $service = $this->service->find($id);
        return $resource ? new ServiceResource($service) :  $service;
    }

    public function getAllActive()
    {
        $service = $this->service->whereIsActive(1)->get();
        return ServiceResource::collection($service);
    }

    public function store($data)
    {
        try {
            if (!empty($data['image_file'])) {
                $data['image'] = $this->uploadFile($data['image_file'], $this->uploadPath, $data['title']);
            }
            return $this->service->create($data);
        } catch (Exception $e) {
            return false;
        }
    }

    public function update($data, $id)
    {
        try {
            $service = $this->find($id);
            if (!empty($data['image_file'])) {
                if (!empty($service->image)) {
                    $this->deleteUploaded($service->image, $this->uploadPath, $service->title);
                }
                $data['image'] = $this->uploadFile($data['image_file'], $this->uploadPath, $service->title);
            }
            return $service->update($data);
        } catch (Exception $e) {
            return false;
        }
    }

    public function delete($id)
    {
        try {
            $service = $this->find($id);
            if (!empty($service->image)) {
                $this->deleteUploaded($service->image, $this->uploadPath, $service->title);
            }
            return $service->delete($id);
        } catch (Exception $e) {
            return false;
        }
    }

    public function paginateFront($limit = 6){
        $service = $this->service->whereIsActive(1)->orderBy('id', "DESC");
        return $service->paginate($limit);
    }

    public function getBySlug($slug){
        return $this->service->where('slug', $slug)->first();
    }
}
