<?php

namespace App\Services\Cms\NewsAndUpdates;

use App\Http\Resources\Cms\NewsAndUpdates\NewsAndUpdatesResource;
use App\Models\Cms\NewsAndUpdates\NewsAndUpdates;
use App\Services\Image\ImageService;

class NewsAndUpdatesService extends ImageService
{
    protected $newsAndUpdates;

    public function __construct(NewsAndUpdates $newsAndUpdates)
    {
        $this->newsAndUpdates = $newsAndUpdates;
    }

    public function paginate($limit = 25, $request)
    {
        $newsAndUpdates = $this->newsAndUpdates->where(function ($query) use ($request) {
            if ($request->filled('title'))
                $query->where('title', 'like', '%' . $request->title . '%');

            if ($request->filled('is_active')) {
                $query->whereIsActive($request->is_active);
            }
        })->paginate($limit);

        return NewsAndUpdatesResource::collection($newsAndUpdates);
    }

    public function getBySlug($slug)
    {
        return $this->newsAndUpdates->whereSlug($slug)->whereIsActive(1)->first();
    }

    public function frontPaginate($limit = 25)
    {
        $album = $this->newsAndUpdates->orderBy('id', "DESC")->whereIsActive(1)
            ->paginate($limit);
        return NewsAndUpdatesResource::collection($album);
    }

    public function store($data)
    {
        try {
            if (isset($data['image_file'])) {
                $data['social_share_image'] = $this->uploadFileAndImagesndImages($data['image_file'], 'news-and-updates');
            }
            return $this->newsAndUpdates->create($data);
        } catch (\Exception $ex) {
            return false;
        }
    }

    public function find($newsAndUpdates_id)
    {
        $newsAndUpdates = $this->newsAndUpdates->find($newsAndUpdates_id);
        if (!empty($newsAndUpdates))
            return $newsAndUpdates;
        return null;
    }

    public function update($id, $data)
    {
        try {
            $newsAndUpdates = $this->find($id);
            if (isset($data['image_file'])) {
                if (!empty($newsAndUpdates->social_share_image)) {
                    $this->deleteUploaded($this->uploadPath, $newsAndUpdates->social_share_image);
                }
                $data['social_share_image'] = $this->uploadFileAndImagesndImages($data['image_file'], 'news-and-updates');
            }
            return $newsAndUpdates->update($data);
        } catch (\Exception $ex) {
            return false;
        }
    }

    public function delete($id)
    {
        try {
            $newsAndUpdates = $this->find($id);
            if (!empty($newsAndUpdates->social_share_image)) {
                $this->deleteUploaded($this->uploadPath, $newsAndUpdates->social_share_image);
            }
            return $newsAndUpdates->delete();
        } catch (\Exception $ex) {
            return false;
        }
    }

    public function findByColumn($column, $value)
    {
        return $this->newsAndUpdates->where($column, $value)->first();
    }


    public function findByColumns($data = [], $all = true, $limit = 0)
    {
        $result = $this->newsAndUpdates->where(function ($query) use ($data) {
            foreach ($data as $key => $value) {
                $query->where($key, $data[$key]);
            }
        });
        if (!empty($limit) || $limit != 0) {
            $result = $result->take($limit);
            return NewsAndUpdatesResource::collection($result);
        } else if ($all) {
            $result = $result->get();
            return NewsAndUpdatesResource::collection($result);
        } else {
            $$result = $result->first();
            return $$result ? new NewsAndUpdatesResource($result) : null;
        }
    }

    public function getAllActive()
    {
        $newsandupdates = $this->newsAndUpdates->whereIsActive(1)->get();
        return  NewsAndUpdatesResource::collection($newsandupdates);
    }
}
