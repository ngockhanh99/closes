<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LoginRequest extends FormRequest
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
        $rules = [
            'user_login_name' => 'required|max:255',
            'password'        => 'required|min:6'
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'required'    => ':attribute không được bỏ trống',
        ];
    }

    public function attributes()
    {
        return [
            'user_login_name' => 'Tên tài khoản',
            'password'        => 'Mật khẩu',
        ];
    }

}
