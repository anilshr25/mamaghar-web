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

    public function paginate($limit, $request)
    {
        $inquerys = $this->inquery->where(function ($query) use ($request) {
            if ($request->filled('name')) {
                $query->where('name', 'like', '%' . $request->name . '%');
            }
            if ($request->filled('is_active')) {
                $query->whereIsActive($request->is_active);
            }
        })->orderBy('id', 'DESC');
        $inquery = $inquerys->paginate($limit);
        return InqueryResources::collection($inquery);
    }

    public function find($id)
    {
        $inquery = $this->inquery->whereId($id)->first();
        return new InqueryResources($inquery);
    }

    public function store($data)
    {

            return $this->inquery->create($data);

    }
    public function update($data, $id)
    {

            $inquery = $this->find($id);
            return $inquery->update($data);

    }

    public function delete($id)
    {

            $inquery = $this->find($id);
            return $inquery->delete($id);

    }
}
