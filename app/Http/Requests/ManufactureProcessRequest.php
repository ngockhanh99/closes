<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ManufactureProcessRequest extends FormRequest
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
            'name' => 'required|unique:mca_manufacture_process,name,'.$this->id,
            'spec_id' => 'required',
            'standard_id' => 'required',
            'media_id' => 'required',
            'issued_date'=>'required',
//            'code' => 'required|unique:mca_manufacture_process,code,'.$this->id
        ];
    }
}
