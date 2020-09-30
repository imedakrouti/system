<?php

namespace Student\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransferRequest extends FormRequest
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
            'leaved_date'      => 'required',
            'leave_reason'      => 'required',
            'school_id'      => 'required',
            'student_id'      => 'required',            
        ];
    }
    public function messages()
    {
        return [
            'leaved_date.required'       => trans('student::local.leaved_date_required'),
            'leave_reason.required'      => trans('student::local.leave_reason_required'),
            'school_id.required'         => trans('student::local.school_id_required'),
            'student_id.required'        => trans('student::local.student_id_required'),
            
        ];
    }    
}
