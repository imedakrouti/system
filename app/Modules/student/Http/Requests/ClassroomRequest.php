<?php

namespace Student\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClassroomRequest extends FormRequest
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
            'ar_name_classroom'     => 'required',
            'en_name_classroom'     => 'required',                      
            'grade_id'              => 'required',                      
            'division_id'           => 'required',                      
            'year_id'               => 'required',                      
            'sort'                  => 'required|numeric'
        ];
    }
    public function messages()
    {
        return [
            'ar_name_classroom.required'    => trans('student::local.ar_name_classroom_required'),
            'en_name_classroom.required'    => trans('student::local.en_name_classroom_required'),            
            'division_id.required'          => trans('student::local.division_required'),            
            'year_id.required'              => trans('student::local.year_required'),            
            'grade_id.required'             => trans('student::local.grade_required'),            
            'sort.required'                 => trans('student::local.sort_required'),            
            'sort.numeric'                  => trans('student::local.sort_numeric'),
        ];
    }
}
