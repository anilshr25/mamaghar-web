<?php

namespace App\Services\Cms\Event;

use App\Http\Resources\Cms\Event\EventResource;
use App\Models\Cms\Event\Event;
use App\Services\Image\ImageService;
use Exception;

class EventService extends ImageService
{
    protected $event;

    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    public function paginate($limit, $request)
    {
        $events = $this->event->where(function ($query) use ($request) {
            if ($request->has('title')) {
                $query->where('title', 'like', '%' . $request->get('title') . '%');
            }
            if ($request->has('location')) {
                $query->where('location', 'like', '%' . $request->get('location') . '%');
            }
            if ($request->has('start_date')) {
                $query->where('start_date', 'like', '%' . $request->get('date') . '%');
            }
            if ($request->has('time')) {
                $query->where('time', 'like', '%' . $request->get('time') . '%');
            }
        })->orderBy('id', "DESC")->paginate($limit);

        return EventResource::collection($events);
    }

    public function find($id)
    {
        $event = $this->event->whereId($id)->first();
        return new EventResource($event);
    }

    public function store($data)
    {
        try {
            if (isset($data['image_file']) && $data['image_file'] != "undefined") {
                $data['image'] = $this->uploadFile($data['image_file'], 'event');
            }
            return $this->event->create($data);
        } catch (Exception $e) {
            return false;
        }
    }

    public function update($data, $id)
    {
        try {
            $event = $this->find($id);
            if (isset($data['image_file']) && $data['image_file'] != "undefined") {
                if (!empty($event->image)) {
                    $this->deleteUploaded($event->image, 'event', $event->title, true);
                }
                $data['image'] = $this->uploadFile($data['image_file'], 'event');
            }
            return $event->update($data);
        } catch (Exception $e) {
            return false;
        }
    }

    public function delete($id)
    {
        try {
            $event = $this->find($id);
            if (!empty($event->image)) {
                $this->deleteUploaded($event->image, 'event', $event->title, true);
            }
            return $event->delete();
        } catch (Exception $e) {
            return false;
        }
    }

    public function findByColumn($column, $value)
    {
        return $this->event->where($column, $value)->first();
    }

    public function getFutureEvents(){
        return $this->event->whereIsActive(1)->where('start_date', '>=', now())->get();
    }

    public function getPastEvents(){
        return $this->event->whereIsActive(1)->where('start_date', '<=', now())->get();
    }
}
