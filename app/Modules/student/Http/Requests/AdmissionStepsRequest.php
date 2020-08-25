<?php

namespace Student\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdmissionStepsRequest extends FormRequest
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
            'ar_step'  => 'required',
            'en_step'  => 'required',
            'sort'     => 'required'
        ];
    }
    public function messages()
    {
        return [
            'ar_step.required'   => trans('student::local.ar_step_required'),
            'en_step.required'   => trans('student::local.en_step_required'),
            'sort.required'      => trans('student::local.sort_required')
        ];
    }
}
