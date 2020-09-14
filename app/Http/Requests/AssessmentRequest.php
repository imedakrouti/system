<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssessmentRequest extends FormRequest
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
            // 'student_id'    => 'required'            
        ];
    }
    public function messages()
    {
        return [
            // 'student_id.required'         => trans('student::local.student_id_required'),            
        ];
    }
}
