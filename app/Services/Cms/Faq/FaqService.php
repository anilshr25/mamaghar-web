<?php


namespace App\Services\Cms\Faq;


use App\Http\Resources\Cms\Faq\FaqResource;
use App\Models\Cms\Faq\Faq;
use Exception;

class FaqService
{
    protected $faq;

    public function __construct(Faq $faq)
    {
        $this->faq = $faq;
    }

    public function all()
    {
        $faq = $this->faq->orderBy('position', "ASC")->get();
        return FaqResource::collection($faq);
    }

    public function paginate($limit, $request)
    {
        $faqs = $this->faq->where(function ($query) use ($request) {

            if ($request->filled('title'))
                $query->where('title', 'like', '%' . $request->title . '%');

            if ($request->filled('category_id')) {
                $query->whereCategroyId($request->category_id);
            }

            if ($request->filled('is_active')) {
                $query->whereIsActive($request->is_active);
            }
        })->orderBy('position', 'ASC');
        $faqs = $faqs->get();
//        $faq = $this->faq->orderBy('position', "ASC")->get();
        return FaqResource::collection($faqs);
    }

    public function find($id)
    {
        $faq = $this->faq->whereId($id)->first();
        return new FaqResource($faq);
    }

    public function sort($data)
    {
        try {
            if (sizeof($data) > 0) {
                foreach ($data as $i => $id) {
                    $faq = $this->faq->whereId($id)->first();
                    if (!empty($faq)) {
                        $v['position'] = ($i + 1);
                        $faq->update($v);
                    }
                }
            }
            return true;
        } catch
        (\Exception $ex) {
            return $ex;
        }
    }

    public function getAllActive()
    {
        $faq = $this->faq->whereIsActive(1)->get();
        return FaqResource::collection($faq);
    }

    public function store($data)
    {
        try{
            $data['position'] = $this->faq->orderBy('position','DESC')->first();
            $data['position'] = $data['position'] && $data['position']->position ? $data['position']->position + 1 : 1;
            return $this->faq->create($data);
        }
        catch(Exception $e)
        {
            return false;
        }
    }
    public function update($data, $id)
    {
        try{
            $faq = $this->find($id);
            return $faq->update($data);
        }
        catch(Exception $e)
        {
            return false;
        }
    }

    public function delete($id)
    {
        try{
            $faq = $this->find($id);
            $faq->delete($id);
            return true;
        }
        catch(Exception $e)
        {
            return false;
        }
    }
}
