<?php

namespace App\Services\Cms\Slider;

use App\Http\Resources\Cms\Slider\SliderResource;
use App\Models\Cms\Slider\Slider;
use App\Services\Image\ImageService;

class SliderService extends ImageService
{
    protected $slider;
    protected $uploadPath = "slider";


    public function __construct(Slider $slider)
    {
        $this->slider = $slider;
    }

    public function paginate($data, $limit = 25)
    {
        $slider = $this->slider->orderBy('position', "ASC")->where(function ($qry) use ($data) {
            if (isset($data['title']) && !empty($data['title'])) {
                $qry->where('title', 'like', "%" . $data['title'] . "%");
            }
            if (isset($data['active']) && !empty($data['active'])) {
                $flag = $data['active'] == "active" ? 1 : 0;
                $qry->whereIsActive($flag);
            }
        })->paginate($limit);
        return SliderResource::collection($slider);
    }
    public function getFrontSlider()
    {
        $slider = $this->slider->whereIsActive(1)->orderBy('position', "ASC")
            ->get();
        if (count($slider) > 0)
            return SliderResource::collection($slider);
        else
            return [];
    }
    public function featuredImage($limit = 25)
    {
        $slider = $this->slider->whereIsFeatured(1)->orderBy('id', "DESC")
            ->paginate($limit);
        return SliderResource::collection($slider);
    }

    public function getBySlug($slug)
    {
        return $this->slider->whereSlug($slug)->first();
    }


    public function store($data)
    {
        try {
            if (!empty($data['image_file'])) {
                $data['image'] = $this->uploadFile($data['image_file'], $this->uploadPath, $data['title']);
            }
            $data['show_button'] = (isset($data['show_button']) && $data['show_button'] == true) ? 1 : 0;
            $data['new_tab'] = (isset($data['new_tab']) && $data['new_tab'] == true) ? 1 : 0;
            $data['is_active'] = (isset($data['is_active']) && $data['is_active'] == true) ? 1 : 0;
            return $this->slider->create($data);
        } catch (\Exception $ex) {
            return false;
        }
    }
    public function sort($data)
    {
        try {
            if (sizeof($data) > 0) {
                foreach ($data as $i => $id) {
                    $slider = $this->slider->whereId($id)->first();
                    if (!empty($slider)) {
                        $v['position'] = ($i + 1);
                        $slider->update($v);
                    }
                }
            }
            return true;
        } catch (\Exception $ex) {
            return $ex;
        }
    }
    public function find($id)
    {
        $slider = $this->slider->find($id);
        if (!empty($slider)) {
            return new SliderResource($slider);
        }
        return false;
    }

    public function update($id, $data)
    {
        try {
            $data['is_active'] = (isset($data['is_active']) && $data['is_active'] == true) ? 1 : 0;
            $data['new_tab'] = (isset($data['new_tab']) && $data['new_tab'] == true) ? 1 : 0;
            $data['show_button'] = (isset($data['show_button']) && $data['show_button'] == true) ? 1 : 0;
            $data['heading_text'] = isset($data['heading_text']) ? $data['heading_text'] : null;
            $data['sub_heading_text'] = isset($data['sub_heading_text']) ? $data['sub_heading_text'] : null;
            $data['description'] = isset($data['description']) ? $data['description'] : null;
            $slider = $this->find($id);
            if (!empty($data['image_file'])) {
                if (!empty($slider->image)) {
                    $this->deleteUploaded($slider->image, $this->uploadPath, $slider->title);
                }
                $data['image'] = $this->uploadFile($data['image_file'], $this->uploadPath, $slider->title);
            }
            return $slider->update($data);
        } catch (\Exception $ex) {
            return false;
        }

    }

    public function makeNonFeatured($id)
    {
        $sliders = $this->slider->where('id', "!=", $id)->get();
        if ($sliders->count() > 0) {
            foreach ($sliders as $v) {
                $v->is_featured = 0;
                $v->save();
            }
        }
    }

    public function delete($id)
    {
        try {
            $slider = $this->slider->find($id);
            if (!empty($slider->image)) {
                $this->deleteUploaded($slider->image, $this->uploadPath, $slider->title);
            }
            return $slider->delete();
        } catch (\Exception $ex) {
            return false;
        }
    }

    public function findByColumn($column, $slider)
    {
        return $this->slider->where($column, $slider)->first();
    }

    public function findByColumns($data, $limit = 0)
    {
        $result = $this->slider->where(function ($query) use ($data) {
            foreach ($data as $key => $slider) {
                $query->where($key, $data[$key]);
            }
        });
        if (!empty($limit) || $limit != 0) {
            $result = $result->take($limit)->get();
            return SliderResource::collection($result);
        } else {
            return new SliderResource($result);
        }
    }
}
