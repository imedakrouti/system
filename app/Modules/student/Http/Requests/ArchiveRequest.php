<?php

namespace Student\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArchiveRequest extends FormRequest
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
            'file_name'         => 'required|mimes:pdf,jpeg,png,jpg|max:5000',            
            'document_name'     => 'required',
            'student_id'        => 'required'
        ];
    }
    public function messages()
    {
       return [
        'document_name.required'             => trans('student::local.document_name_required'),
        'student_id.required'                => trans('student::local.student_id_required'),
        'file_name.required'                 => trans('student::local.file_name_required'),
        'file_name.max'                      => trans('student::local.file_name_max'),
        'file_name.mimes'                    => trans('student::local.file_name_mimes'),
       ];
    }
}
