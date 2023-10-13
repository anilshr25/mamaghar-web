<?php

namespace App\Http\Controllers\Admin\Cms\Event;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cms\Event\EventRequest;
use App\Services\Cms\Event\EventService;
use App\Services\Cms\Event\Gallery\EventGalleryService;
use Illuminate\Http\Request;

class EventController extends Controller
{
    protected $event;
    protected $eventGallery;

    public function __construct(EventService $event, EventGalleryService $eventGallery)
    {
        $this->event = $event;
        $this->eventGallery = $eventGallery;
    }

    public function index(Request $request)
    {
        return $this->event->paginate(20, $request);
    }

    public function store(EventRequest $request)
    {
        $event = $this->event->store($request->all());
        if ($event)
            return response(['status' => "OK"], 200);
        return response(['status' => "ERROR"], 500);
    }

    public function show($id)
    {
        if ($event = $this->event->find($id))
            return response(['status' => "OK", 'event' => $event], 200);
        return response(['status' => "ERROR"], 500);
    }

    public function update(Request $request, $id)
    {
        $event = $this->event->update($request->all(), $id);
        if ($event)
            return response(['status' => "OK"], 200);
        return response(['status' => "ERROR"], 500);
    }

    public function destroy($id)
    {
        if ($this->event->delete($id) && $this->eventGallery->deleteEvent($id)) {
            return response(['status' => "OK"], 200);
        }
        return response(['status' => "ERROR"], 500);
    }
}
