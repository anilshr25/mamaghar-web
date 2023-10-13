<?php

namespace App\Http\Controllers\Admin\Room;

use App\Http\Controllers\Controller;
use App\Http\Requests\Room\RoomRequest;
use App\Services\Room\RoomService;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    protected $room;

    public function __construct(RoomService $room)
    {
        $this->room = $room;
    }

    public function index(Request $request)
    {
        return $this->room->paginate(10, $request);
    }

    public function store(RoomRequest $request)
    {
        $room = $this->room->store($request->all());
        if ($room)
            return response(['status' => "OK"], 200);
        return response(['status' => "ERROR"], 500);
    }

    public function show($id)
    {
        if ($room = $this->room->find($id))
            return response(['status' => "OK", 'room' => $room], 200);
        return response(['status' => "ERROR"], 500);
    }

    public function update(RoomRequest $request, $id)
    {
        $room = $this->room->update($request->all(), $id);
        if ($room)
            return response(['status' => "OK"], 200);
        return response(['status' => "ERROR"], 500);
    }

    public function destroy($id)
    {
        if ($this->room->delete($id))
            return response(['status' => "OK"], 200);
        return response(['status' => "ERROR"], 500);
    }
}
