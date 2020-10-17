<?php

namespace Staff\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SectionRequest extends FormRequest
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
            'ar_section'     => 'required|max:25',
            'en_section'     => 'required|max:25',
            'sort'           => 'required'
        ];
    }
    public function messages()
    {
        return [
            'ar_section.required'         => trans('staff::local.ar_section_required'),
            'ar_section.max'              => trans('staff::local.ar_section_max'),
            'en_section.required'         => trans('staff::local.en_section_required'),
            'en_section.max'              => trans('staff::local.en_section_max'),
            'sort.required'               => trans('staff::local.sort_required')
        ];
    }
}
