<?php

namespace App\Http\Requests\Inquery;

use Illuminate\Foundation\Http\FormRequest;

class InqueryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "first_name" => "required",
            "last_name" => "required",
            "email" => "required",
            "phone_no" => "required",
            "subject" => "required",
            "message" => "required",
            "is_replied" => "required",
            "status" => "required",
        ];
    }
}
