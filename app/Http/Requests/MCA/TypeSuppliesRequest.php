<?php

namespace App\Http\Requests\MCA;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TypeSuppliesRequest extends FormRequest {

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
            'name' => 'required',
            'unit_id' => 'required',
            'spec_id' =>'required'
        ];
        return $rules;
    }

}
