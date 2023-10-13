<?php

namespace App\Http\Controllers\Admin\Cms\NewsAndUpdates;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cms\NewsAndUpdatesRequest\NewsAndUpdatesRequest;
use App\Services\Cms\NewsAndUpdates\NewsAndUpdatesService;
use Illuminate\Http\Request;

class NewsAndUpdatesController extends Controller
{
    protected $newsAndUpdates;

    public function __construct(NewsAndUpdatesService $newsAndUpdates)
    {
        $this->newsAndUpdates = $newsAndUpdates;
    }

    public function index(Request $request)
    {
        return $this->newsAndUpdates->paginate(20, $request);
    }

    public function store(NewsAndUpdatesRequest $request)
    {
        $newsAndUpdates = $this->newsAndUpdates->store($request->all());
        if ($newsAndUpdates)
            return response(['status' => "OK"], 200);
        return response(['status' => "ERROR"], 500);
    }

    public function show($id)
    {
        if ($newsAndUpdates = $this->newsAndUpdates->find($id))
            return response(['status' => "OK", 'newsAndUpdates' => $newsAndUpdates], 200);
        return response(['status' => "ERROR"], 500);
    }

    public function update($id, Request $request)
    {
        $newsAndUpdates = $this->newsAndUpdates->update($id, $request->all());
        if ($newsAndUpdates)
            return response(['status' => "OK"], 200);
        return response(['status' => "ERROR"], 500);
    }

    public function destroy($id)
    {
        if ($this->newsAndUpdates->delete($id))
            return response(['status' => "OK"], 200);
        return response(['status' => "ERROR"], 500);
    }
}
