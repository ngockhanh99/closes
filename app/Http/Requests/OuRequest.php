<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Cores\Cores_ou;
use Illuminate\Validation\Rule;

class OuRequest extends FormRequest {

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
        $coresOu = new Cores_ou();
        $ouLevel = $coresOu->get_ou_level();
        $rules = [
            'ou_level' => [
                'required',
                Rule::in($ouLevel),
            ]
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
            $parent_id = isset(request()->parent_id) ? request()->parent_id : 0;
            $sibling_name = Cores_ou::where('parent_id', $parent_id)->pluck('ou_name')->toArray();
            $rule_tmp = [
                'ou_name' => [
                    'required',
                    Rule::notIn($sibling_name)]
            ];
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
            $parent_id = isset(request()->parent_id) ? request()->parent_id : 0;
            $sibling_name = Cores_ou::where('ou_id', '!=', request()->id)->where('parent_id', $parent_id)->pluck('ou_name')->toArray();
            $rule_tmp = [
                'id' => 'exists:cores_ou,ou_id,' . request()->id,
                'ou_name' => [
                    'required',
                    Rule::notIn($sibling_name)]
            ];
        }
        $rules = array_merge($rules, $rule_tmp);
    }

    private function _method_delete(array &$rules = [])
    {
        if (request()->method == 'DELETE')
        {
            $rules = ['id' => 'exists:cores_ou,ou_id,' . request()->id];
        }
    }

}
