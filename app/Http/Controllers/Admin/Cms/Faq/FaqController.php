<?php

namespace App\Http\Controllers\Admin\Cms\Faq;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cms\Faq\FaqRequest;
use App\Services\Cms\Faq\FaqService;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    protected $faq;

    public function __construct(FaqService $faq)
    {
        $this->faq = $faq;
    }

    public function index(Request $request)
    {
        return $this->faq->paginate(25, $request);
    }

    public function sort(Request $request)
    {
        if ($this->faq->sort($request->all())) {
            return response(['status' => "OK",], 200);
        }
        return response(['status' => 'ERROR', 'errors' => 'Problem occurred.'], 200);
    }

    public function store(FaqRequest $request)
    {
        $faq = $this->faq->store($request->all());
        if ($faq)
            return response(['status' => "OK"], 200);
        return response(['status' => "ERROR"], 500);
    }

    public function show($id)
    {
        if ($faq = $this->faq->find($id))
            return response(['status' => "OK", 'faq' => $faq], 200);
        return response(['status' => "ERROR"], 500);
    }

    public function update(FaqRequest $request, $id)
    {
        $faq = $this->faq->update($request->all(), $id);
        if ($faq)
            return response(['status' => "OK"], 200);
        return response(['status' => "ERROR"], 500);
    }

    public function destroy($id)
    {
        if ($this->faq->delete($id))
            return response(['status' => "OK"], 200);
        return response(['status' => "ERROR"], 500);
    }
}
