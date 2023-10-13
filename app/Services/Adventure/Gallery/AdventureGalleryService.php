<?php

namespace App\Services\Adventure\Gallery;

use App\Http\Resources\Adventure\Gallery\AdventureGalleryResource;
use App\Models\Adventure\Gallery\AdventureGallery;
use App\Services\Image\ImageService;

class AdventureGalleryService extends ImageService
{
    protected $adventureGallery;

    public function __construct(AdventureGallery $adventureGallery)
    {
        $this->adventureGallery = $adventureGallery;
    }

    public function paginate($adventureId)
    {
        $eventGalleries = $this->adventureGallery->whereAdventureId($adventureId)->orderBy('position', "ASC")->get();

        return AdventureGalleryResource::collection($eventGalleries);
    }

    public function find($adventureId, $id)
    {
        $adventureGallery = $this->adventureGallery->whereAdventureId($adventureId)->find($id);
        return $adventureGallery ? new AdventureGalleryResource($adventureGallery) : null;
    }

    public function store($adventureId, $data)
    {
            for ($i=0; $i < count($data['file']); $i++) {
                $gallery = [];
                $gallery['adventure_id'] = $adventureId;
                $gallery['position'] = $this->adventureGallery->orderBy('position','DESC')->first();
                $gallery['position'] = $gallery['position'] && $gallery['position']->position ? $gallery['position']->position + 1 : 1;
                if (isset($data['file'][$i]) && $data['file'][$i] != "undefined") {
                    $gallery['file'] = $this->uploadFile($data['file'][$i], 'adventure/gallery');
                }
                $this->adventureGallery->create($gallery);
            }
            return true;
    }

    public function update($adventureId, $data, $id)
    {
        try {
            $adventureGallery = $this->find($adventureId, $id);
            if (isset($data['image_file']) && $data['image_file'] != "undefined") {
                if (!empty($adventureGallery->file)) {
                    $this->deleteUploaded($adventureGallery->file, 'adventure/gallery');
                }
                $data['file'] = $this->uploadFile($data['image_file'], 'adventure/gallery');
            }
            return $adventureGallery->update($data);
        } catch (\Exception $e) {
            return false;
        }
    }

    public function delete($adventureId, $id)
    {
        try {
            $adventureGallery = $this->find($adventureId, $id);
            if (!empty($adventureGallery->file)) {
                $this->deleteUploaded($adventureGallery->file, 'event/gallery');
            }
            return $adventureGallery->delete();
        } catch (\Exception $e) {
            return false;
        }
    }

    public function deleteEvent($adventureId)
    {
        try {
            $eventGalleries = $this->findByColumns(['event_id' => $adventureId]);
            foreach ($eventGalleries as $adventureGallery) {
                if (!empty($adventureGallery->file)) {
                    $this->deleteUploaded($adventureGallery->file, 'event/gallery');
                }
                $adventureGallery->delete();
            }
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function findByColumn($column, $value)
    {
        return $this->adventureGallery->where($column, $value)->first();
    }

    public function findByColumns($data = null, $all = true, $resource = true, $limit = 0)
    {
        $result = $this->adventureGallery->where(function ($query) use ($data) {
            foreach ($data as $key => $value) {
                $query->where($key, $data[$key]);
            }
        });
        if ($limit > 0)
            $result = $result->take($limit);
        if ($all) {
            $result = $result->get();
            if ($resource)
                return AdventureGalleryResource::collection($result);
            return $result;
        } else {
            $result = $result->first();
            if ($result)
                return new AdventureGalleryResource($result);
            return $result;
        }
    }
}
