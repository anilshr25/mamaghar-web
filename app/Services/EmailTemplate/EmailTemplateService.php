<?php

namespace App\Services\EmailTemplate;

use App\Http\Resources\EmailTemplate\EmailTemplateResource;
use App\Models\EmailTemplate\EmailTemplate;
use http\Env\Request;

class EmailTemplateService
{

    protected $emailTemplate;

    public function __construct(EmailTemplate $emailTemplate)
    {
        $this->emailTemplate = $emailTemplate;
    }

    public function paginate($limit = 25, $request) {
        $emailTemplates = $this->emailTemplate->where(function ($query) use ($request) {
            if ($request->filled('roles'))
                $query->whereRole($request->roles);
            if ($request->filled('is_active'))
                $query->whereIsActive($request->is_active);
            if ($request->filled('title'))
                $query->where('title', 'like', '%' . $request->title . '%');
        });
        $emailTemplates = $emailTemplates->orderBy('id', "DESC")->paginate($limit);
        return EmailTemplateResource::collection($emailTemplates);
    }

    public function all()
    {
        $emailTemplate = $this->emailTemplate->whereIsActive(1)->orderBy('position', "ASC")->get();
        return EmailTemplateResource::collection($emailTemplate);
    }

    public function store($data)
    {
        try {
            $data['is_active'] = (isset($data['is_active']) && $data['is_active'] == true) ? true : 0;
            return $this->emailTemplate->create($data);
        } catch
        (\Exception $ex) {
            return false;
        }
    }

    public function find($id)
    {
        $emailTemplate = $this->emailTemplate->find($id);
        return new EmailTemplateResource($emailTemplate);
    }

    public function update($id, $data)
    {
       try {
        $data['is_active'] = (isset($data['is_active']) && $data['is_active'] == true) ? true : 0;
        $emailTemplate = $this->find($id);
        return $emailTemplate->update($data);
       } catch (\Exception $ex) {
           return false;
       }
    }

    public function delete($id)
    {
        try {
            $emailTemplate = $this->find($id);
            return $emailTemplate->delete();
        } catch (\Exception $ex) {
            return false;
        }
    }

    public function findByColumn($column, $value)
    {
        return $this->emailTemplate->where($column, $value)->first();
    }


    public function findByColumns($data, $limit = 0)
    {
        $result = $this->emailTemplate->where(function ($query) use ($data) {
            foreach ($data as $key => $value) {
                $query->where($key, $data[$key]);
            }
        });
        if (!empty($limit) || $limit != 0) {
            $result = $result->take($limit)->get();
            return EmailTemplateResource::collection($result);
        } else {
            return new EmailTemplateResource($result);
        }
    }

    public function findByWhereIn($column, $value, $data = [], $all = false, $limit = null)
    {
        $result = $this->emailTemplate->whereIn($column, $value)->where(function ($query) use ($data) {
            foreach ($data as $key => $value) {
                $query->where($key, $data[$key]);
            }
        });
        if ($all) {
            if (!empty($limit))
                $result = $result->take($limit);
            return EmailTemplateResource::collection($result->get());
        } else {
            return new EmailTemplateResource($result);
        }
    }
    public function cloneEmailTemplate($request)
    {
        $emailTemplate=$this->emailTemplate->whereType($request['type'])->whereRole($request['role'])->first();

        if($emailTemplate){
            $emailTemplate=$this->update($emailTemplate->id,$request);
        }else{
            $emailTemplate=$this->store($request);
        }
       if($emailTemplate)
           return true;
       return false;
    }
}
