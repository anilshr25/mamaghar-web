<?php

namespace App\Services\Room\Gallery;

use App\Http\Resources\Room\Gallery\RoomGalleryResource;
use App\Models\Room\Gallery\RoomGallery;
use App\Services\Image\ImageService;

class RoomGalleryService extends ImageService
{
    protected $roomGallery;

    public function __construct(RoomGallery $roomGallery)
    {
        $this->roomGallery = $roomGallery;
    }

    public function paginate($roomId)
    {
        $roomGalleries = $this->roomGallery->whereRoomId($roomId)->orderBy('position', "ASC")->get();

        return RoomGalleryResource::collection($roomGalleries);
    }

    public function find($roomId, $id)
    {
        $roomGallery = $this->roomGallery->whereRoomId($roomId)->find($id);
        return $roomGallery ? new RoomGalleryResource($roomGallery) : null;
    }

    public function store($roomId, $data)
    {
        for ($i = 0; $i < count($data['files']); $i++) {
            $gallery = [];
            $gallery['room_id'] = $roomId;
            $gallery['position'] = $this->roomGallery->orderBy('position', 'DESC')->first();
            $gallery['position'] = $gallery['position'] && $gallery['position']->position ? $gallery['position']->position + 1 : 1;
            if (isset($data['files'][$i]) && $data['files'][$i] != "undefined") {
                $gallery['file'] = $this->uploadFile($data['files'][$i], 'room/gallery');
            }
            $this->roomGallery->create($gallery);
        }
        return true;
    }

    public function update($roomId, $data, $id)
    {
        try {
            $roomGallery = $this->find($roomId, $id);
            if (isset($data['image_file']) && $data['image_file'] != "undefined") {
                if (!empty($roomGallery->file)) {
                    $this->deleteUploaded($roomGallery->file, 'room/gallery');
                }
                $data['file'] = $this->uploadFile($data['image_file'], 'room/gallery');
            }
            return $roomGallery->update($data);
        } catch (\Exception $e) {
            return false;
        }
    }

    public function delete($roomId, $id)
    {
        try {
            $roomGallery = $this->find($roomId, $id);
            if (!empty($roomGallery->file)) {
                $this->deleteUploaded($roomGallery->file, 'room/gallery');
            }
            return $roomGallery->delete();
        } catch (\Exception $e) {
            return false;
        }
    }

    public function changeFeatureImage($roomId, $id)
    {
        try {
            $roomGallery = $this->find($roomId, $id);
            $roomGalleries = $this->roomGallery->whereRoomId($roomId)->whereNotIn('id', $id)->get();

            foreach ($roomGalleries as $item) {
                $item->update(['is_feature_image' => 1]);
            }
            return $roomGallery->update(['is_feature_image' => 1]);
        } catch (\Exception $e) {
            return false;
        }
    }

    public function deleteRoom($roomId)
    {
        try {
            $roomGalleries = $this->findByColumns(['room_id' => $roomId]);
            foreach ($roomGalleries as $roomGallery) {
                if (!empty($roomGallery->file)) {
                    $this->deleteUploaded($roomGallery->file, 'room/gallery');
                }
                $roomGallery->delete();
            }
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function findByColumn($column, $value)
    {
        return $this->roomGallery->where($column, $value)->first();
    }

    public function findByColumns($data = null, $all = true, $resource = true, $limit = 0)
    {
        $result = $this->roomGallery->where(function ($query) use ($data) {
            foreach ($data as $key => $value) {
                $query->where($key, $data[$key]);
            }
        });
        if ($limit > 0)
            $result = $result->take($limit);
        if ($all) {
            $result = $result->get();
            if ($resource)
                return RoomGalleryResource::collection($result);
            return $result;
        } else {
            $result = $result->first();
            if ($result)
                return new RoomGalleryResource($result);
            return $result;
        }
    }
}
