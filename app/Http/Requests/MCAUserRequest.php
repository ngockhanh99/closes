<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MCAUserRequest extends FormRequest
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
            'user_email' => 'required|email',
            'password' => 'required_without:id|confirmed|alpha_dash|min:5',
            'user_name' => 'required|min:3|max:255',
            'user_phone' => 'required|min:5|max:255',
            'user_role' => 'required',
            'user_avatar' => 'nullable',
            'user_address' => 'nullable|min:3',
            'province_id' => 'required|exists:cores_province,id',
            'district_id' => 'required|exists:cores_district,id',
            'village_id' => 'required|exists:cores_village,id',
            'type_id' => 'required',
            'spec_id' => 'required',
            'enterprise_website' => 'nullable|max:255|url',
        ];
    }
}
