<?php

namespace App\Http\Controllers\Admin\Cms\Inquery;

use App\Http\Controllers\Controller;
use App\Http\Requests\Inquery\InqueryRequest;
use App\Services\Cms\Inquery\InqueryService;
use Illuminate\Http\Request;

class InqueryController extends Controller
{
    protected $inquery;

    public function __construct(InqueryService $inquery)
    {
        $this->inquery = $inquery;
    }

    public function index(Request $request)
    {
        return $this->inquery->all($request);
    }

    public function sort(Request $request)
    {
        if ($this->inquery->sort($request->all())) {
            return response(['status' => "OK",], 200);
        }
        return response(['status' => 'ERROR', 'errors' => 'Problem occurred.'], 200);
    }

    public function store(InqueryRequest $request)
    {
        $inquery = $this->inquery->store($request->all());
        if ($inquery)
            return response(['status' => "OK"], 200);
        return response(['status' => "ERROR"], 500);
    }

    public function show($id)
    {
        if ($inquery = $this->inquery->find($id))
            return response(['status' => "OK", 'inquery' => $inquery], 200);
        return response(['status' => "ERROR"], 500);
    }

    public function update(InqueryRequest $request, $id)
    {
        $inquery = $this->inquery->update($request->all(), $id);
        if ($inquery)
            return response(['status' => "OK"], 200);
        return response(['status' => "ERROR"], 500);
    }

    public function destroy($id)
    {
        if ($this->inquery->delete($id))
            return response(['status' => "OK"], 200);
        return response(['status' => "ERROR"], 500);
    }
}
