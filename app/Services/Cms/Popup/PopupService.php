<?php

namespace App\Services\Cms\Popup;

use App\Http\Resources\Cms\Popup\PopupResource;
use App\Models\Cms\Popup\Popup;
use Carbon\Carbon;
use Exception;
use App\Services\Image\ImageService;

class PopupService extends ImageService
{
    protected $popup;

    public function __construct(Popup $popup)
    {
        $this->popup = $popup;
    }

    public function all()
    {
        $popup = $this->popup->orderBy('id', "DESC")->get();
        return PopupResource::collection($popup);
    }

    public function paginate($limit)
    {
        $popup = $this->popup->orderBy('id', "DESC")->paginate($limit);
        return PopupResource::collection($popup);
    }

    public function find($id)
    {
        $popup = $this->popup->whereId($id)->first();
        return new PopupResource($popup);
    }

    public function sort($data)
    {
        try {
            if (sizeof($data) > 0) {
                foreach ($data as $i => $id) {
                    $popup = $this->popup->whereId($id)->first();
                    if (!empty($popup)) {
                        $v['position'] = ($i + 1);
                        $popup->update($v);
                    }
                }
            }
            return true;
        } catch
        (\Exception $ex) {
            return $ex;
        }
    }

    public function store($data)
    {
        try{
            if (isset($data['file']) && $data['file'] != "undefined") {
                $data['file'] = $this->uploadFile($data['file'], 'popup', $data['title']);
            }
            $data['position'] = $this->popup->orderBy('position','DESC')->first();
            $data['position'] = $data['position'] && $data['position']->position ? $data['position']->position + 1 : 1;
            return $this->popup->create($data);
        }
        catch(Exception $e)
        {
            return false;
        }
    }
    public function update($data,$id)
    {
        try{
            $popup = $this->find($id);
            if (isset($data['file']) && $data['file'] != "undefined") {
                $data['file'] = $this->uploadFile($data['file'], 'popup', $data['title']);
                if($popup->file != null){
                    $this->deleteUploaded($popup->file,'popup', $popup->title);
                }
            }
            return $popup->update($data);
        }
        catch(Exception $e)
        {
            return false;
        }
    }

    public function delete($id)
    {
        try{
            $popup = $this->find($id);
            if($popup->file != null){
                $this->deleteUploaded($popup->file, 'popup', $popup->title);
            }
            return $popup->delete($id);
        }
        catch(Exception $e)
        {
            return false;
        }
    }

    public function getPopUp(){

        $popup = $this->popup::where('is_active',1)->where(function ($query){
            //        Get Today Date;
            $date = Carbon::now()->toDateString();
            $query->where('start_date','<=',$date)->where('end_date','>=',$date);
        })->orderBy('position',"asc")->get();
        return PopupResource::collection($popup);
    }
}
