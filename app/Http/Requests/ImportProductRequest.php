<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImportProductRequest extends FormRequest
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
            'name' => 'required|min:2|max:255',
            'date_needed' => 'required|date',
            'amount' => 'required|min:0|numeric',
            'listMediaId' => 'required',
            'type_product_id' =>'required',
            'price' =>'required',
            'description' => 'required',
            'standard_id' =>'required',
        ];
    }
}
