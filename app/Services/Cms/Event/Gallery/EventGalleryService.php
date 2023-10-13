<?php

namespace App\Services\Cms\Event\Gallery;

use App\Http\Resources\Cms\Event\Gallery\EventGalleryResource;
use App\Models\Cms\Event\Gallery\EventGallery;
use App\Services\Image\ImageService;

class EventGalleryService extends ImageService
{
    protected $eventGallery;

    public function __construct(EventGallery $eventGallery)
    {
        $this->eventGallery = $eventGallery;
    }

    public function paginate($eventId, $limit = 25)
    {
        $eventGalleries = $this->eventGallery->whereEventId($eventId)->orderBy('position', "ASC")->paginate($limit);

        return EventGalleryResource::collection($eventGalleries);
    }

    public function find($eventId, $id)
    {
        $eventGallery = $this->eventGallery->whereEventId($eventId)->find($id);
        return $eventGallery ? new EventGalleryResource($eventGallery) : null;
    }

    public function store($eventId, $data)
    {
            for ($i=0; $i < count($data['file']); $i++) {
                $gallery = [];
                $gallery['event_id'] = $eventId;
                $gallery['position'] = $this->eventGallery->orderBy('position','DESC')->first();
                $gallery['position'] = $gallery['position'] && $gallery['position']->position ? $gallery['position']->position + 1 : 1;
                if (isset($data['file'][$i]) && $data['file'][$i] != "undefined") {
                    $gallery['file'] = $this->uploadFile($data['file'][$i], 'event/gallery');
                }
                $this->eventGallery->create($gallery);
            }
            return true;

    }

    public function update($eventId, $data, $id)
    {
        try {
            $eventGallery = $this->find($eventId, $id);
            if (isset($data['image_file']) && $data['image_file'] != "undefined") {
                if (!empty($eventGallery->file)) {
                    $this->deleteUploaded($eventGallery->file, 'event/gallery');
                }
                $data['file'] = $this->uploadFile($data['image_file'], 'event/gallery');
            }
            return $eventGallery->update($data);
        } catch (\Exception $e) {
            return false;
        }
    }

    public function delete($eventId, $id)
    {
        try {
            $eventGallery = $this->find($eventId, $id);
            if (!empty($eventGallery->file)) {
                $this->deleteUploaded($eventGallery->file, 'event/gallery');
            }
            return $eventGallery->delete();
        } catch (\Exception $e) {
            return false;
        }
    }

    public function deleteEvent($eventId)
    {
        try {
            $eventGalleries = $this->findByColumns(['event_id' => $eventId]);
            foreach ($eventGalleries as $eventGallery) {
                if (!empty($eventGallery->file)) {
                    $this->deleteUploaded($eventGallery->file, 'event/gallery');
                }
                $eventGallery->delete();
            }
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function findByColumn($column, $value)
    {
        return $this->eventGallery->where($column, $value)->first();
    }

    public function findByColumns($data = null, $all = true, $resource = true, $limit = 0)
    {
        $result = $this->eventGallery->where(function ($query) use ($data) {
            foreach ($data as $key => $value) {
                $query->where($key, $data[$key]);
            }
        });
        if ($limit > 0)
            $result = $result->take($limit);
        if ($all) {
            $result = $result->get();
            if ($resource)
                return EventGalleryResource::collection($result);
            return $result;
        } else {
            $result = $result->first();
            if ($result)
                return new EventGalleryResource($result);
            return $result;
        }
    }
}
