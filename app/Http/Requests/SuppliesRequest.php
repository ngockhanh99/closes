<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SuppliesRequest extends FormRequest
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

            'name' => 'required|unique:mca_supplies,name,'.$this->id,
            'price' => 'required',
            'quantily'=>'required',
            'unit_id'=>'nullable|exists:mca_units,id',
            'type_supplies_id' =>'required',
            'status'=>'required',
            'media_id'=>'required',
            'quantity_sold' => 'required',
            'manufacture_date' =>'required',
        ];
    }
}
