<?php

namespace App\Services\Cms\Media;

use App\Http\Resources\Cms\Media\MediaResource;
use App\Models\Cms\Media\Media;
use App\Services\Image\ImageService;

class MediaService extends ImageService
{

    protected $uploadPath = "media";
    protected $media;

    public function __construct(Media $media)
    {
        $this->media = $media;
    }

    public function all()
    {
        $medias = $this->media->orderBy('position')->get();
        return MediaResource::collection($medias);
    }

    public function store($data)
    {
        try {
            return $this->media->create($data);
        } catch (\Exception $ex) {
            return false;
        }
    }

    public function uploadMultipleImage($data)
    {
        if (sizeof($data) > 0) {

            if (isset($data['files'])) {
                foreach ($data['files'] as $file) {
                    if (!empty($file)) {
                        $media = [];
                        $media['position'] = $this->media->orderBy('position', 'DESC')->first();
                        $media['position'] = $media['position'] && $media['position']->position ? $media['position']->position + 1 : 1;
                        $media['image'] = $this->uploadFile($file, $this->uploadPath, null, 350, 234);
                        $media['type'] = checkFileType($media['image']);
                        $this->media->create($media);
                    }
                }
            }
        }
        return true;
    }

    public function find($id)
    {
        $media = $this->media->find($id);
        if (!empty($media))
            return $media;
        return null;
    }

    public function delete($id)
    {
        try {
            $media = $this->find($id);
            if (!empty($media->image))
                $this->deleteUploaded($this->uploadPath, $media->image);
            return $media->delete();
        } catch (\Exception $ex) {
            return false;
        }
    }

    public function findByColumn($column, $value)
    {
        return $this->media->where($column, $value)->first();
    }

    public function findByColumns($data = null, $all = false, $resource = true, $limit = 0)
    {
        $result = $this->media->where(function ($query) use ($data) {
            foreach ($data as $key => $value) {
                if (!empty($data[$key]))
                    $query->where($key, $data[$key]);
            }
        });
        if ($limit > 0)
            $result = $result->take($limit);
        if ($all) {
            $result = $result->get();
            if ($resource)
                return MediaResource::collection($result);
            return $result;
        } else {
            $result = $result->first();
            if ($resource)
                return new MediaResource($result);
            return $result;
        }
    }

}
