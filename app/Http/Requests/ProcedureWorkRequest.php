<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProcedureWorkRequest extends FormRequest
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
            'procedure_id' => 'required|exists:mca_procedure,id',
            'work_content' => 'required|min:3',
            'begin_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'job_description' => 'nullable',
            'note' => 'nullable',
        ];
    }
}
