<?php

namespace App\Services\Cms\Blog\Category;

use App\Http\Resources\Cms\Blog\Category\BlogCategoryResource;
use App\Models\Cms\Blog\Category\BlogCategory;
use Exception;

class BlogCategoryService
{
    protected $blogCategory;

    public function __construct(BlogCategory $blogCategory)
    {
        $this->blogCategory = $blogCategory;
    }

    public function paginate($limit, $request)
    {
        $blogCategory = $this->blogCategory->where(function ($query) use ($request) {
            if ($request->filled('name')) {
                $query->where('name', 'like', '%' . $request->name . '%');
            }
        });
        $blogCategory = $blogCategory->paginate($limit);
        return BlogCategoryResource::collection($blogCategory);
    }

    public function store($data)
    {
        try {
            return $this->blogCategory->create($data);
        } catch (Exception $e) {
            return false;
        }
    }

    public function find($id)
    {
        return new BlogCategoryResource($this->blogCategory->whereId($id)->first());
    }

    public function update($id, $data)
    {
        try {
            $blogCategory = $this->find($id);
            return $blogCategory->update($data);
        } catch (Exception $e) {
            return false;
        }
    }

    public function delete($id)
    {
        try {
            $blogCategory = $this->find($id);
            return $blogCategory->delete();
        } catch (Exception $e) {
            return false;
        }
    }

    public function getAllActive(){
        $blogCategory = $this->blogCategory->whereIsActive(1)->orderBy('id', "DESC")->paginate();
        return BlogCategoryResource::collection($blogCategory);
    }

    public function allFront(){
        return $this->blogCategory->whereIsActive(1)->get();
    }
}

