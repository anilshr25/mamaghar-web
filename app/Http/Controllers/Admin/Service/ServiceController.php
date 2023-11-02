<?php

namespace App\Http\Controllers\Admin\Service;

use App\Http\Controllers\Controller;
use App\Http\Requests\Service\ServiceRequest;
use App\Services\Service\ServiceService;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    protected $service;

    public function __construct(ServiceService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        return $this->service->paginate(10, $request);
    }

    public function store(ServiceRequest $request)
    {
        $service = $this->service->store($request->all());
        if ($service)
            return response(['status' => "OK"], 200);
        return response(['status' => "ERROR"], 500);
    }

    public function show($id)
    {
        if ($service = $this->service->find($id))
            return response(['status' => "OK", 'service' => $service], 200);
        return response(['status' => "ERROR"], 500);
    }

    public function update(ServiceRequest $request, $id)
    {
        $service = $this->service->update($request->all(), $id);
        if ($service)
            return response(['status' => "OK"], 200);
        return response(['status' => "ERROR"], 500);
    }

    public function destroy($id)
    {
        if ($this->service->delete($id))
            return response(['status' => "OK"], 200);
        return response(['status' => "ERROR"], 500);
    }
}
