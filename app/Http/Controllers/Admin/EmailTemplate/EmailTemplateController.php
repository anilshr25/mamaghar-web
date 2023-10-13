<?php

namespace App\Http\Controllers\Admin\EmailTemplate;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmailTemplate\EmailTemplateRequest;
use App\Services\EmailTemplate\EmailTemplateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class EmailTemplateController extends Controller
{
    public $emailTemplate;

    public function __construct(EmailTemplateService $emailTemplate)
    {
        $this->emailTemplate = $emailTemplate;
    }

    public function index(Request $request)
    {
        $user = auth()->user();
        return $this->emailTemplate->paginate(25, $request,$user);
    }

    public function store(EmailTemplateRequest $request)
    {
        $emailTemplate = $this->emailTemplate->store($request->all());
        if ($emailTemplate)
            return response(['status' => "OK"], 200);
        return response(['status' => 'ERROR'], 500);
    }

    public function update(EmailTemplateRequest $request, $id)
    {
        $emailTemplate = $this->emailTemplate->update($id, $request->all());
        if ($emailTemplate)
            return response(['status' => "OK"], 200);
        return response(['status' => 'ERROR'], 500);
    }

    public function destroy($id)
    {
        if ($this->emailTemplate->delete($id))
            return response(['status' => "OK"], 200);
        return response(['status' => 'ERROR'], 500);
    }


    public function show($id)
    {
        if ($emailTemplate = $this->emailTemplate->find($id))
            return response(['status' => "OK", 'email_template' => $emailTemplate], 200);
        return response(['status' => 'ERROR'], 500);
    }

    public function getLevelByDetail($emailTemplate)
    {
        $emailTemplate = $this->emailTemplate->findByColumn('email_template', $emailTemplate);
        if ($emailTemplate)
            return response(['status' => "OK", 'emailTemplate' => $emailTemplate], 200);
        return response(['status' => 'ERROR'], 500);
    }

    public function cloneEmailTemplate(Request $request)
    {
        $emailTemplate=$this->emailTemplate->cloneEmailTemplate($request->all());
        if($emailTemplate)
            return response(['status' => $emailTemplate], 200);
        return response(['status' => $emailTemplate], 500);
    }
}
