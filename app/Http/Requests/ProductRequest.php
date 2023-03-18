<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'name' => 'required|min:3',
            'manufacture_process_id' => 'nullable|exists:mca_manufacture_process,id',
            'standard_id' => 'required',
            'type_product_id' => 'required|exists:mca_type_product,id',
            'spec_id' => 'nullable|exists:mca_spec,id',
            'price' => 'min:0|numeric',
            'price_processed' => 'min:0|numeric',
            'unit_id' => 'nullable|exists:mca_units,id',
            'stock_status' => 'required|numeric',
            'listMediaId' => 'required',
        ];
    }
}
