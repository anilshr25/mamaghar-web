<?php

namespace App\Http\Controllers\Admin\Cms\Blog;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cms\Blog\BlogRequest;
use App\Services\Cms\Blog\BlogService;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    protected $blog;

    public function __construct(BlogService $blog)
    {
        $this->blog = $blog;
    }

    public function index(Request $request)
    {
        return $this->blog->paginate(25, $request);
    }

    public function store(BlogRequest $request)
    {
        if ($this->blog->store($request->all())) {
            return response(['status' => "OK",], 200);
        }
        return response(['status' => 'ERROR'], 200);
    }

    public function show($id)
    {
        if ($blog = $this->blog->find($id))
            return response(['status' => "OK", 'blog' => $blog], 200);
        return response(['status' => "ERROR"], 500);
    }

    public function update(Request $request, $id)
    {
        $blog = $this->blog->update($request->all(), $id);
        if ($blog)
            return response(['status' => "OK"], 200);
        return response(['status' => "ERROR"], 500);
    }

    public function destroy($id)
    {
        if ($this->blog->delete($id))
            return response(['status' => "OK"], 200);
        return response(['status' => "ERROR"], 500);
    }
}
