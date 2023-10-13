<?php

namespace App\Services\Cms\Notice;

use App\Http\Resources\Cms\Notice\NoticeResource;
use App\Models\Cms\Notice\Notice;
use Carbon\Carbon;
use Exception;

class NoticeService
{
    protected $notice;

    public function __construct(Notice $notice)
    {
        $this->notice = $notice;
    }

    public function all($request)
    {
        $notices = $this->notice->where(function ($query) use ($request) {
           if($request->filled('name')){
               $query->where('name', 'like', '%' . $request->name . '%');
           }
           if ($request->filled('is_active')){
               $query->whereIsActive($request->is_active);
           }
        })->orderBy('position', 'ASC');
        $notice = $notices->get();
        return NoticeResource::collection($notice);
    }

    public function paginate($limit)
    {
        $notice = $this->notice->orderBy('id', "DESC")->paginate($limit);
        return NoticeResource::collection($notice);
    }

    public function find($id)
    {
        $notice = $this->notice->whereId($id)->first();
        return new NoticeResource($notice);
    }

    public function sort($data)
    {
        try {
            if (sizeof($data) > 0) {
                foreach ($data as $i => $id) {
                    $notice = $this->notice->whereId($id)->first();
                    if (!empty($notice)) {
                        $v['position'] = ($i + 1);
                        $notice->update($v);
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
            $data['position'] = $this->notice->orderBy('position','DESC')->first();
            $data['position'] = $data['position'] && $data['position']->position ? $data['position']->position + 1 : 1;
            return $this->notice->create($data);
        }
        catch(Exception $e)
        {
            return false;
        }
    }
    public function update($data, $id)
    {
        try{
            $notice = $this->find($id);
            return $notice->update($data);
        }
        catch(Exception $e)
        {
            return false;
        }
    }

    public function delete($id)
    {
        try{
            $notice = $this->find($id);
            return $notice->delete($id);
        }
        catch(Exception $e)
        {
            return false;
        }
    }

    public function getNotice(){
        $notice = $this->notice::where('is_active',1)->orderBy('position')->where(function ($query){
            $date = Carbon::now()->toDateString();
            $query->where('visible_from_date','<=',$date)->orWhereNull('visible_from_date');
        })->get();
        return NoticeResource::collection($notice);
    }
}
