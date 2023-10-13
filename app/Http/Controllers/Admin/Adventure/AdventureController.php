<?php

namespace App\Http\Controllers\Admin\Adventure;

use App\Http\Controllers\Controller;
use App\Http\Requests\Adventure\AdventureRequest;
use App\Services\Adventure\AdventureService;
use Illuminate\Http\Request;

class AdventureController extends Controller
{
    protected $adventure;

    public function __construct(AdventureService $adventure)
    {
        $this->adventure = $adventure;
    }

    public function index(Request $request)
    {
        return $this->adventure->paginate(10, $request);
    }

    public function store(AdventureRequest $request)
    {
        $adventure = $this->adventure->store($request->all());
        if($adventure)
            return response(['status' => "OK"], 200);
        return response(['status' =>"ERROR"], 500);
    }

    public function show($id)
    {
        if($adventure = $this->adventure->find($id))
            return response(['status' => "OK", 'adventure' => $adventure], 200);
        return response(['status' => "ERROR"], 500);
    }

    public function update(AdventureRequest $request, $id)
    {
        $adventure = $this->adventure->update($request->all(), $id);
        if($adventure)
            return response(['status' => "OK"], 200);
        return response(['status' => "ERROR"], 500);
    }

    public function destroy($id)
    {
        if($this->adventure->delete($id))
            return response(['status' => "OK"], 200);
        return response(['status' => "ERROR"], 500);
    }
}
