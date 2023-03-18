<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PersonnelRequest extends FormRequest
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
            'personnel_perform'=>'required',
            'name' => 'required',
            'code' => 'required',
            'represent' => 'required',
            'leader' => 'required',
            'supervisor' => 'required',
            'media_id' => 'required',
        ];
    }
}
