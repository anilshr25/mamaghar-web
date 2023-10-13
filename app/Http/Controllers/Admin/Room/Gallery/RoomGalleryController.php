<?php

namespace App\Http\Controllers\Admin\Room\Gallery;

use App\Http\Controllers\Controller;
use App\Services\Room\Gallery\RoomGalleryService;
use Illuminate\Http\Request;

class RoomGalleryController extends Controller
{
    protected $roomGallery;

    public function __construct(RoomGalleryService $roomGallery)
    {
        $this->roomGallery = $roomGallery;
    }

    public function index($roomId)
    {
        return $this->roomGallery->paginate($roomId);
    }

    public function store($roomId, Request $request)
    {
        $roomGallery = $this->roomGallery->store($roomId, $request->all());
        if ($roomGallery)
            return response(['status' => "OK"], 200);
        return response(['status' => "ERROR"], 500);
    }

    public function show($roomId, $id)
    {
        if ($roomGallery = $this->roomGallery->find($roomId, $id))
            return response(['status' => "OK", 'roomGallery' => $roomGallery], 200);
        return response(['status' => "ERROR"], 500);
    }

    public function update($roomId, Request $request, $id)
    {
        $roomGallery = $this->roomGallery->update($roomId, $request->all(), $id);
        if ($roomGallery)
            return response(['status' => "OK"], 200);
        return response(['status' => "ERROR"], 500);
    }

    public function destroy($roomId, $id)
    {
        if ($this->roomGallery->delete($roomId, $id))
            return response(['status' => "OK"], 200);
        return response(['status' => "ERROR"], 500);
    }

    public function changeFeatureImage($roomId, $id)
    {
        if ($this->roomGallery->changeFeatureImage($roomId, $id))
        return response(['status' => "OK"], 200);
    return response(['status' => "ERROR"], 500);
    }
}
