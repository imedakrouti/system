<?php

namespace Student\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class AdmissionDocRequest extends FormRequest
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
            'ar_document_name'          => 'required',
            'en_document_name'          => 'required',                      
            'sort'                      => 'required|numeric'
        ];
    }
    public function messages()
    {
        return [
            'ar_document_name.required'     => trans('student::local.ar_document_name_required'),
            'en_document_name.required'     => trans('student::local.en_document_name_required'),            
            'sort.required'                 => trans('student::local.sort_required'),            
            'sort.numeric'                  => trans('student::local.sort_numeric'),

        ];
    }
}
