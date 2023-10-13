<?php

namespace App\Http\Requests\AdminUser;

use Illuminate\Foundation\Http\FormRequest;

class AdminUserRequest extends FormRequest
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
            "email" => "bail|required|email|unique:admin_users",
            "password" => "bail|required|min:8",
            "address_line_1" => "required",
            "mobile_no" => "required|unique:admin_users",
            "user_type" => "required",
            "is_active" => "required",
        ];
    }

    public function filters()
    {
        $filter = [
            'first_name' => 'trim|escape',
            'last_name' => 'trim|escape',
            'email' => 'trim|escape|lowercase',
        ];
        return $filter;
    }
}
