<?php

namespace App\Http\Requests\Auth\UserRegistration;

use Illuminate\Foundation\Http\FormRequest;

class UserRegistrationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "first_name" => "required",
            "last_name" => "required",
            "email" => "bail|required|email|unique:users",
            "password" => "bail|required|min:8",
            "mobile_no" => "bail|required|unique:users"
        ];
    }
}
