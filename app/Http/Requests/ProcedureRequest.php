<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProcedureRequest extends FormRequest
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
            'product_id' => 'required|exists:mca_products,id',
            'begin_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'total_area' => 'nullable|numeric',
            'manufacture_area' => 'nullable|numeric',
        ];
    }
}
