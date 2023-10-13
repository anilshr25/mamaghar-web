<?php


namespace App\Services\Cms\Faq\Category;


use App\Http\Resources\Cms\Faq\Category\FaqCategoryResource;
use App\Models\Cms\Faq\Category\FaqCategory;
use Exception;

class FaqCategoryService
{
    protected $faqCategory;
    public function __construct(FaqCategory $faqCategory)
    {
        $this->faqCategory = $faqCategory;
    }

    public function all()
    {
        $faqCategory = $this->faqCategory->whereIsActive(1)->orderBy('id', "DESC")->get();
        return FaqCategoryResource::collection($faqCategory);
    }

    public function paginate($limit, $request)
    {
        $faqCategory = $this->faqCategory->where(function ($query) use ($request) {

            if ($request->filled('title'))
                $query->where('title', 'like', '%' . $request->title . '%');

            if ($request->filled('is_active')) {
                $query->whereIsActive($request->is_active);
            }
        })->orderBy('position', 'ASC');

        $faqCategories = $faqCategory->get();

        return FaqCategoryResource::collection($faqCategories);
    }

    public function find($id)
    {
        $faqCategory = $this->faqCategory->whereId($id)->first();
        return new FaqCategoryResource($faqCategory);
    }

    public function sort($data)
    {
        try {
            if (sizeof($data) > 0) {
                foreach ($data as $i => $id) {
                    $faqCategory = $this->faqCategory->whereId($id)->first();
                    if (!empty($faqCategory)) {
                        $v['position'] = ($i + 1);
                        $faqCategory->update($v);
                    }
                }
            }
            return true;
        } catch
        (\Exception $ex) {
            return $ex;
        }
    }

    public function store($data)
    {
        try{
            $data['position'] = $this->faqCategory->orderBy('position','DESC')->first();
            $data['position'] = $data['position'] && $data['position']->position ? $data['position']->position + 1 : 1;
            $this->faqCategory->create($data);
            return true;
        }
        catch(Exception $e)
        {
            return false;
        }
    }
    public function update($data, $id)
    {
        try{
            $faqCategory = $this->find($id);
            $faqCategory->update($data);
            return true;
        }
        catch(Exception $e)
        {
            return false;
        }
    }

    public function delete($id)
    {
        try{
            $faqCategory = $this->find($id);
            $faqCategory->delete($id);
            return true;
        }
        catch(Exception $e)
        {
            return false;
        }
    }

    public function getFaqCategory(){
        $faq = $this->faqCategory->where('is_active',1)->get();
        return FaqCategoryResource::collection($faq);
    }

    public function getAllFaqCategoryWithFaq(){
        return $this->faqCategory->with('faqs')->where('is_active',1)->get();
    }

}
