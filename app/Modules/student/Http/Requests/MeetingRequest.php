<?php

namespace Student\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MeetingRequest extends FormRequest
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
            'start'             => 'required',
            'end'               => 'required',
            'interview_id'      => 'required',
            'father_id'         => 'required'
        ];
    }
    public function messages()
    {
        return [
            'start.required'            => trans('student::local.start_required'),
            'end.required'              => trans('student::local.end_required'),
            'interview_id.required'     => trans('student::local.interview_id_required'),
            'father_id.required'        => trans('student::local.father_id_required')
        ];
    }
}
