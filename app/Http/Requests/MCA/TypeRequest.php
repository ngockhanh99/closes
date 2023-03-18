<?php

namespace App\Http\Requests\MCA;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TypeRequest extends FormRequest {

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
            'name' => 'required'
        ];

        //Them moi
        $this->_method_post($rules);
        $this->_method_put($rules);
        $this->_method_delete($rules);

        return $rules;
    }

    /**
     * validator insert
     * @param array $rules
     */
    private function _method_post(array &$rules = [])
    {

        $rule_tmp = [];
        if (request()->method == 'POST')
        {
        }

        $rules = array_merge($rules, $rule_tmp);
    }

    /**
     * validator edit user
     * @param array $rules
     */
    private function _method_put(array &$rules = [])
    {
        $rule_tmp = [];
        if (request()->method == 'PUT')
        {
            $rule_tmp = [
            ];
        }
        $rules = array_merge($rules, $rule_tmp);
    }

    private function _method_delete(array &$rules = [])
    {
        if (request()->method == 'DELETE')
        {
        }
    }

}
