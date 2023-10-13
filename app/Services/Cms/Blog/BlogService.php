<?php

namespace App\Services\Cms\Blog;

use App\Http\Resources\Cms\Blog\BlogResource;
use App\Models\Cms\Blog\Blog;
use App\Services\Image\ImageService;

class BlogService extends ImageService
{
    protected $blog;

    public function __construct(Blog $blog)
    {
        $this->blog = $blog;
    }

    public function paginate($limit, $request)
    {
        $blogs = $this->blog->where(function ($query) use ($request) {
            if ($request->filled('title')) {
                $query->where('title', 'like', '%' . $request->title . '%');
            }
            if($request->filled('status')) {
                $query->where('is_active', $request->status);
            }
        })->orderBy('id', "DESC")->paginate($limit);

        return BlogResource::collection($blogs);
    }

    public function store($data)
    {
            if (isset($data['author_file']) && $data['author_file'] != "undefined") {
                $data['author_image'] = $this->uploadFile($data['author_file'], 'blog', $data['title']);
            }
            return $this->blog->create($data);

    }

    public function find($id)
    {
        $blog = $this->blog->whereId($id)->first();
        return new BlogResource($blog);
    }

    public function update($data, $id)
    {
            $blog = $this->find($id);
            if (isset($data['author_file']) && $data['author_file'] != "undefined") {
                if (!empty($blog->author_image)) {
                    $this->deleteUploaded($blog->image, 'blog', $blog->title, true);
                }
                $data['author_image'] = $this->uploadFile($data['author_file'], 'blog', $data['title']);
            }
            return $blog->update($data);

    }


    public function getAllActive()
    {
        $blog = $this->blog->whereIsActive(1)->get();
        return BlogResource::collection($blog);
    }

    public function delete($id)
    {
        try {
            $blog = $this->find($id);
            if (!empty($blog->image)) {
                $this->deleteUploaded($blog->image, 'blog', $blog->title, false);
            }
            return $blog->delete();
        } catch (\Exception $e) {
            return false;
        }
    }

    public function paginateFront($limit = 6){
        $blog = $this->blog->whereIsActive(1)->orderBy('id', "DESC");
        return $blog->paginate($limit);
    }

    public function getBySlug($slug){
        return $this->blog->where('slug', $slug)->first();
    }

}
