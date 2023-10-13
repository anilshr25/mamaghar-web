<?php

namespace App\Http\Controllers\Admin\Cms\Event\Gallery;

use App\Http\Controllers\Controller;
use App\Services\Cms\Event\Gallery\EventGalleryService;
use Illuminate\Http\Request;

class EventGalleryController extends Controller
{
    protected $eventGallery;

    public function __construct(EventGalleryService $eventGallery)
    {
        $this->eventGallery = $eventGallery;
    }

    public function index($eventId)
    {
        return $this->eventGallery->paginate($eventId, 20);
    }

    public function store($eventId, Request $request)
    {
        $eventGallery = $this->eventGallery->store($eventId, $request->all());
        if ($eventGallery)
            return response(['status' => "OK"], 200);
        return response(['status' => "ERROR"], 500);
    }

    public function show($eventId, $id)
    {
        if ($eventGallery = $this->eventGallery->find($eventId, $id))
            return response(['status' => "OK", 'eventGallery' => $eventGallery], 200);
        return response(['status' => "ERROR"], 500);
    }

    public function update($eventId, Request $request, $id)
    {
        $eventGallery = $this->eventGallery->update($eventId, $request->all(), $id);
        if ($eventGallery)
            return response(['status' => "OK"], 200);
        return response(['status' => "ERROR"], 500);
    }

    public function destroy($eventId, $id)
    {
        if ($this->eventGallery->delete($eventId, $id))
            return response(['status' => "OK"], 200);
        return response(['status' => "ERROR"], 500);
    }
}
