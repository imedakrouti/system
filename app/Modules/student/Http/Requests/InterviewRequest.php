<?php

namespace Student\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InterviewRequest extends FormRequest
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
            'ar_name_interview'  => 'required',
            'en_name_interview'  => 'required',
            'sort'               => 'required'
        ];
    }
    public function messages()
    {
        return [
            'ar_name_interview.required'   => trans('student::local.ar_name_interview_required'),
            'en_name_interview.required'   => trans('student::local.en_name_interview_required'),
            'sort.required'                => trans('student::local.sort_required')
        ];
    }
}
