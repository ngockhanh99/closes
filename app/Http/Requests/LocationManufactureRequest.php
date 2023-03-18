<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LocationManufactureRequest extends FormRequest
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
            'name' => 'required',
            'code' => 'required',
            'total_area' => 'required|integer',
            'manufacture_area' => 'required|integer',
            'address' => 'required',
            'province_id' => 'required|exists:cores_province,id',
            'district_id' => 'required|exists:cores_district,id',
            'village_id' => 'exists:cores_village,id',
            'media_id' => 'required',
        ];
    }
}
