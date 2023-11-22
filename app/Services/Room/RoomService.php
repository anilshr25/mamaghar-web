<?php

namespace App\Services\Room;

use App\Http\Resources\Room\RoomResource;
use App\Models\Room\Room;
use App\Services\Image\ImageService;
use Exception;

class RoomService extends ImageService
{

    protected $room;
    protected $uploadPath = "room";

    public function __construct(Room $room)
    {
        $this->room = $room;
    }

    public function paginate($limit = 20, $request)
    {
        $rooms = $this->room->where(function ($query) use ($request) {

            if ($request->filled('title'))
                $query->where('title', 'like', '%' . $request->title . '%');

            if ($request->filled('category_id')) {
                $query->whereCategroyId($request->category_id);
            }

            if ($request->filled('is_active')) {
                $query->whereIsActive($request->is_active);
            }
        })->orderBy('id', 'DESC');

        $rooms = $rooms->paginate($limit);

        return RoomResource::collection($rooms);
    }

    public function find($id, $resource = true)
    {
        $room = $this->room->find($id);
        return $resource ? new RoomResource($room) :  $room;
    }

    public function getAllActive()
    {
        $room = $this->room->whereIsActive(1)->get();
        return RoomResource::collection($room);
    }

    public function store($data)
    {
        // try {
            if (!empty($data['image_file'])) {
                $data['image'] = $this->uploadFile($data['image_file'], $this->uploadPath, $data['title']);
            }
            return $this->room->create($data);
        // } catch (Exception $e) {
        //     return false;
        // }
    }

    public function update($data, $id)
    {
        // try {
            $room = $this->find($id);
            if (!empty($data['image_file'])) {
                if (!empty($room->image)) {
                    $this->deleteUploaded($room->image, $this->uploadPath, $room->title);
                }
                $data['image'] = $this->uploadFile($data['image_file'], $this->uploadPath, $room->title);
            }
            return $room->update($data);
        // } catch (Exception $e) {
        //     return false;
        // }
    }

    public function delete($id)
    {
        // try {
            $room = $this->find($id);
            if (!empty($room->image)) {
                $this->deleteUploaded($room->image, $this->uploadPath, $room->title);
            }
            return $room->delete($id);
        // } catch (Exception $e) {
        //     return false;
        // }
    }

    public function paginateFront($limit = 6){
        $room = $this->room->whereIsActive(1)->orderBy('id', "DESC");
        return $room->paginate($limit);
    }

    public function getBySlug($slug){
        return $this->room->where('slug', $slug)->first();
    }
}
