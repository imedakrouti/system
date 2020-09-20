<?php

namespace Student\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StageRequest extends FormRequest
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
            'ar_stage_name'         => 'required',
            'en_stage_name'         => 'required',
            'sort'                  => 'required|numeric'
        ];
    }
    public function messages()
    {
        return [
            'ar_stage_name.required'        => trans('student::local.ar_stage_name_required'),
            'en_stage_name.required'        => trans('student::local.en_stage_name_required'),            
            'sort.required'                 => trans('student::local.sort_required'),
            'sort.numeric'                  => trans('student::local.sort_numeric'),
        ];
    }
}
