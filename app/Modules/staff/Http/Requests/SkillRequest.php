<?php

namespace Staff\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SkillRequest extends FormRequest
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
            'ar_skill'     => 'required|max:25',
            'en_skill'     => 'required|max:25',
            'sort'            => 'required'
        ];
    }
    public function messages()
    {
        return [
            'ar_skill.required'         => trans('staff::local.ar_skill_required'),
            'ar_skill.max'              => trans('staff::local.ar_skill_max'),
            'en_skill.required'         => trans('staff::local.en_skill_required'),
            'en_skill.max'              => trans('staff::local.en_skill_max'),
            'sort.required'                => trans('staff::local.sort_required')
        ];
    }
}
