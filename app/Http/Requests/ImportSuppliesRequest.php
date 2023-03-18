<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImportSuppliesRequest extends FormRequest
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
            'unit_id' => 'nullable|exists:mca_units,id',
            'listMediaId' => 'required',
            'quantity_needed' => 'required|min:0',
            'type_supplies_id' => 'required|exists:mca_type_supplies,id',
            'price' => 'required|min:0',
        ];
    }
}
