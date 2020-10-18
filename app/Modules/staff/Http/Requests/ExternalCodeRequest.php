<?php

namespace Staff\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExternalCodeRequest extends FormRequest
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
            'pattern'           => 'required',
            'replacement'       => 'required',
            'description'       => 'required'
        ];
    }
    public function messages()
    {
        return [
            'pattern.required'             => trans('staff::local.pattern_required'),            
            'replacement.required'         => trans('staff::local.replacement_required'),            
            'description.required'         => trans('staff::local.description_required'),            
            
        ];
    }
}
