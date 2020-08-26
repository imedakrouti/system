<?php

namespace Student\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DesignRequest extends FormRequest
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
            // 'design_name'     => 'required|image|size:1000|mimes:png,jpg',            
            'grade_id'        => 'required',                      
            'division_id'     => 'required',                                  
        ];
    }
    public function messages()
    {
        return [
            'design_name.required'    => trans('student::local.design_name_required'),
            // 'design_name.image'       => trans('student::local.design_type_image'),            
            // 'design_name.size'        => trans('student::local.design_type_size'),            
            // 'design_name.mimes'       => trans('student::local.design_type_mimes'),            
            'division_id.required'    => trans('student::local.division_required'),                        
            'grade_id.required'       => trans('student::local.grade_required'),                        
        ];
    }
}
