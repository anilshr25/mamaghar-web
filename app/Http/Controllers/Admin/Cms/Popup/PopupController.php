<?php

namespace App\Http\Controllers\Admin\Cms\Popup;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cms\Popup\PopupRequest;
use App\Services\Cms\Popup\PopupService;
use Illuminate\Http\Request;

class PopupController extends Controller
{
    protected $popup;

    public function __construct(PopupService $popup)
    {
        $this->popup = $popup;
    }

    public function index()
    {
        return $this->popup->all();
    }

    public function sort(Request $request)
    {
        if ($this->popup->sort($request->all())) {
            return response(['status' => "OK",], 200);
        }
        return response(['status' => 'ERROR', 'errors' => 'Problem occurred.'], 200);
    }

    public function store(PopupRequest $request)
    {
        $popup = $this->popup->store($request->all());
        if ($popup)
            return response(['status' => "OK"], 200);
        return response(['status' => "ERROR"], 500);
    }

    public function show($id)
    {
        if ($popup = $this->popup->find($id))
            return response(['status' => "OK", 'popup' => $popup], 200);
        return response(['status' => "ERROR"], 500);
    }

    public function update(Request $request, $id)
    {
        $popup = $this->popup->update($request->all(), $id);
        if ($popup)
            return response(['status' => "OK"], 200);
        return response(['status' => "ERROR"], 500);
    }

    public function destroy($id)
    {
        if ($this->popup->delete($id))
            return response(['status' => "OK"], 200);
        return response(['status' => "ERROR"], 500);
    }
}
