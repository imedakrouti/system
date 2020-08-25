<?php

namespace Student\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AcceptanceTestRequest extends FormRequest
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
            'ar_test_name'          => 'required',
            'en_test_name'          => 'required',                      
            'grade_id'              => 'required',                      
            'sort'                  => 'required|numeric'
        ];
    }
    public function messages()
    {
        return [
            'ar_test_name.required'     => trans('student::local.ar_test_name_required'),
            'en_test_name.required'     => trans('student::local.en_test_name_required'),            
            'grade_id.required'         => trans('student::local.grade_required'),            
            'sort.required'             => trans('student::local.sort_required'),            
            'sort.numeric'              => trans('student::local.sort_numeric'),

        ];
    }
}
