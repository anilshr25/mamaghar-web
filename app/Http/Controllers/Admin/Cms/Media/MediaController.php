<?php

namespace App\Http\Controllers\Admin\Cms\Media;

use App\Services\Cms\Media\MediaService;
use Illuminate\Http\Request;

class MediaController
{
    protected $media;

    function __construct(MediaService $media)
    {
        $this->media = $media;
    }

    public function index()
    {
        return $this->media->all();
    }

    public function store(Request $request)
    {
        $media = $this->media->uploadMultipleImage($request->all());
        if ($media)
            return response(['status' => "OK"], 200);
        return response(['status' => 'ERROR'], 200);
    }

    public  function destroy($id)
    {
        if ($this->media->delete($id))
            return response(['status' => "OK"], 200);
        return response(['status' => 'ERROR'], 200);
    }
}
