<?php

namespace App\Services\Adventure;

use App\Http\Resources\Adventure\AdventureResource;
use App\Models\Adventure\Adventure;
use App\Services\Image\ImageService;
use App\Services\Traits\UploadPathTrait;
use Exception;

class AdventureService extends ImageService
{

    use UploadPathTrait;
    protected $adventure;

    protected $uploadPath = 'adventure';

    public function __construct(Adventure $adventure)
    {
        $this->adventure = $adventure;
    }

    public function paginate($limit, $request)
    {
        $adventures = $this->adventure->where(function ($query) use ($request) {

            if ($request->filled('title')) {
                $query->where('title', 'like', '%' . $request->title . '%');
            }

            if ($request->filled('category_id')) {
                $query->whereCategoryId($request->category_id);
            }

            if ($request->filled('is_active')) {
                $query->whereIsActive($request->is_active);
            }
        })->orderBy('id', 'DESC');

        $adventures = $adventures->paginate($limit);

        return AdventureResource::collection($adventures);
    }

    public function find($id, $resource = true)
    {
        $adventure = $this->adventure->find($id);
        return $resource ? new AdventureResource($adventure) : $adventure;
    }

    public function store($data)
    {
        try{
            if (!empty($data['image_file'])) {
                $data['image'] = $this->uploadFile($data['image_file'], $this->uploadPath, $data['title']);
            }
            return $this->adventure->create($data);
        }
        catch(Exception $e)
        {
            return false;
        }
    }

    public function getAllActive(){
        $adventure = $this->adventure->whereIsActive(1)->get();
        return AdventureResource::collection($adventure);
    }


    public function update($data, $id)
    {
        try{
            $adventure = $this->find($id);
            if (!empty($data['image_file'])) {
                if (!empty($adventure->image)) {
                    $this->deleteUploaded($adventure->image, $this->uploadPath, $adventure->title);
                }
                $data['image'] = $this->uploadFile($data['image_file'], $this->uploadPath, $adventure->title);
            }
            return $adventure->update($data);
        }
        catch(Exception $e)
        {
            return false;
        }
    }

    public function delete($id)
    {
        try {
            $adventure = $this->find($id);
            if (!empty($adventure->image)) {
                $this->deleteUploaded($adventure->image, 'event/adventure');
            }
            return $adventure->delete($id);
        } catch (Exception $e) {
            return false;
        }
    }
}
