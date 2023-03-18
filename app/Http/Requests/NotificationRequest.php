<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NotificationRequest extends FormRequest {

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
            'content' => 'required|string',
            'ou_ids' => 'required'
        ];

        //Them moi
        $this->_method_post($rules);

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
            $rule_tmp = [
                'content' => 'required|string',
            ];
        }

        $rules = array_merge($rules, $rule_tmp);
    }

    /**
     * validator edit user
     * @param array $rules
     */

}
