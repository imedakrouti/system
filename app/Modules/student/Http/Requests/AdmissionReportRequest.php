<?php

namespace Student\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdmissionReportRequest extends FormRequest
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
            'report_title'      => 'required',
            'report'            => 'required'            
        ];
    }
    public function messages()
    {
        return [
            'report_title.required'   => trans('student::local.report_title_required'),
            'report.required'         => trans('student::local.report_required'),
            
        ];
    }
}
