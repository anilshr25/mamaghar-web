<?php

namespace App\Http\Controllers\Admin\Cms\Notice;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cms\Notice\NoticeRequest;
use App\Services\Cms\Notice\NoticeService;
use Illuminate\Http\Request;

class NoticeController extends Controller
{
    protected $notice;

    public function __construct(NoticeService $notice)
    {
        $this->notice = $notice;
    }

    public function index(Request $request)
    {
        return $this->notice->all($request);
    }

    public function sort(Request $request)
    {
        if ($this->notice->sort($request->all())) {
            return response(['status' => "OK",], 200);
        }
        return response(['status' => 'ERROR', 'errors' => 'Problem occurred.'], 200);
    }

    public function store(NoticeRequest $request)
    {
        $notice = $this->notice->store($request->all());
        if ($notice)
            return response(['status' => "OK"], 200);
        return response(['status' => "ERROR"], 500);
    }

    public function show($id)
    {
        if ($notice = $this->notice->find($id))
            return response(['status' => "OK", 'notice' => $notice], 200);
        return response(['status' => "ERROR"], 500);
    }

    public function update(NoticeRequest $request, $id)
    {
        $notice = $this->notice->update($request->all(), $id);
        if ($notice)
            return response(['status' => "OK"], 200);
        return response(['status' => "ERROR"], 500);
    }

    public function destroy($id)
    {
        if ($this->notice->delete($id))
            return response(['status' => "OK"], 200);
        return response(['status' => "ERROR"], 500);
    }
}
