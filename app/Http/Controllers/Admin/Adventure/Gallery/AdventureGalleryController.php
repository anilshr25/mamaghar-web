<?php

namespace App\Http\Controllers\Admin\Adventure\Gallery;

use App\Http\Controllers\Controller;
use App\Services\Adventure\Gallery\AdventureGalleryService;
use Illuminate\Http\Request;

class AdventureGalleryController extends Controller
{
    protected $adventureGallery;

    public function __construct(AdventureGalleryService $adventureGallery)
    {
        $this->adventureGallery = $adventureGallery;
    }

    public function index($adventureId)
    {
        return $this->adventureGallery->paginate($adventureId);
    }

    public function store($adventureId, Request $request)
    {
        $adventureGallery = $this->adventureGallery->store($adventureId, $request->all());
        if ($adventureGallery)
            return response(['status' => "OK"], 200);
        return response(['status' => "ERROR"], 500);
    }

    public function show($adventureId, $id)
    {
        if ($adventureGallery = $this->adventureGallery->find($adventureId, $id))
            return response(['status' => "OK", 'adventureGallery' => $adventureGallery], 200);
        return response(['status' => "ERROR"], 500);
    }

    public function update($adventureId, Request $request, $id)
    {
        $adventureGallery = $this->adventureGallery->update($adventureId, $request->all(), $id);
        if ($adventureGallery)
            return response(['status' => "OK"], 200);
        return response(['status' => "ERROR"], 500);
    }

    public function destroy($adventureId, $id)
    {
        if ($this->adventureGallery->delete($adventureId, $id))
            return response(['status' => "OK"], 200);
        return response(['status' => "ERROR"], 500);
    }
}
