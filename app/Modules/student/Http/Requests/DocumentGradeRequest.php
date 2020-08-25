<?php

namespace Student\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DocumentGradeRequest extends FormRequest
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
            'admission_document_id'     => 'required',
            'grade_id'                  => 'required',                              
        ];
    }
    public function messages()
    {
        return [
            'admission_document_id.required'    => trans('student::local.admission_document_id_required'),
            'grade_id.required'                 => trans('student::local.grade_id_required'),                        
        ];
    }
}
