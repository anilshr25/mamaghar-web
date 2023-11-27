<?php

namespace App\Services\Cms\Inquery;

use App\Http\Resources\Cms\Inquery\InqueryResources;
use App\Models\Cms\Inquery\Inquery;
use Carbon\Carbon;
use Exception;

class InqueryService
{
    protected $inquery;

    public function __construct(Inquery $inquery)
    {
        $this->inquery = $inquery;
    }

    public function all($request)
    {
        $inquerys = $this->inquery->where(function ($query) use ($request) {
           if($request->filled('name')){
               $query->where('name', 'like', '%' . $request->name . '%');
           }
           if ($request->filled('is_active')){
               $query->whereIsActive($request->is_active);
           }
        })->orderBy('position', 'ASC');
        $inquery = $inquerys->get();
        return InqueryResources::collection($inquery);
    }

    public function paginate($limit)
    {
        $inquery = $this->inquery->orderBy('id', "DESC")->paginate($limit);
        return InqueryResources::collection($inquery);
    }

    public function find($id)
    {
        $inquery = $this->inquery->whereId($id)->first();
        return new InqueryResources($inquery);
    }

    public function sort($data)
    {
        try {
            if (sizeof($data) > 0) {
                foreach ($data as $i => $id) {
                    $inquery = $this->inquery->whereId($id)->first();
                    if (!empty($inquery)) {
                        $v['position'] = ($i + 1);
                        $inquery->update($v);
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
            $data['position'] = $this->inquery->orderBy('position','DESC')->first();
            $data['position'] = $data['position'] && $data['position']->position ? $data['position']->position + 1 : 1;
            return $this->inquery->create($data);
        }
        catch(Exception $e)
        {
            return false;
        }
    }
    public function update($data, $id)
    {
        try{
            $inquery = $this->find($id);
            return $inquery->update($data);
        }
        catch(Exception $e)
        {
            return false;
        }
    }

    public function delete($id)
    {
        try{
            $inquery = $this->find($id);
            return $inquery->delete($id);
        }
        catch(Exception $e)
        {
            return false;
        }
    }

    public function getInquery(){
        $inquery = $this->inquery::where('is_active',1)->orderBy('position')->where(function ($query){
            $date = Carbon::now()->toDateString();
            $query->where('visible_from_date','<=',$date)->orWhereNull('visible_from_date');
        })->get();
        return InqueryResources::collection($inquery);
    }
}
