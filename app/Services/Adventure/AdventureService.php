<?php

namespace App\Services\Adventure;

use App\Http\Resources\Adventure\AdventureResource;
use App\Models\Adventure\Adventure;
use Exception;

class AdventureService
{
    protected $adventure;

    public function __construct(Adventure $adventure)
    {
        $this->adventure = $adventure;
    }

    public function paginate($limit, $request)
    {
        $adventures = $this->adventure->where(function ($query) use ($request) {

            if ($request->filled('title')) {
                $query->where('title', 'like', '%' . $request->title . '%');
            }

            if ($request->filled('category_id')) {
                $query->whereCategoryId($request->category_id);
            }

            if ($request->filled('is_active')) {
                $query->whereIsActive($request->is_active);
            }
        })->orderBy('id', 'DESC');

        $adventures = $adventures->paginate($limit);

        return AdventureResource::collection($adventures);
    }

    public function find($id)
    {
        $adventure = $this->adventure->find($id);
        return new AdventureResource($adventure);
    }

    public function store($data)
    {
        try{
            return $this->adventure->create($data);
        }
        catch(Exception $e)
        {
            return false;
        }
    }

    public function update($data, $id)
    {
        try{
            $adventure = $this->find($id);
            return $adventure->update($data);
        }
        catch(Exception $e)
        {
            return false;
        }
    }

    public function delete($id)
    {
        try{
            $adventure = $this->find($id);
            return $adventure->delete($id);
        }
        catch(Exception $e)
        {
            return false;
        }
    }
}
