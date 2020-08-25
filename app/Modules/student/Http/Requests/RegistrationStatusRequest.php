<?php

namespace Student\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationStatusRequest extends FormRequest
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
            'ar_name_status'   => 'required',
            'en_name_status'   => 'required',                      
            'sort'             => 'required|numeric'
        ];
    }
    public function messages()
    {
        return [
            'ar_name_status.required'       => trans('student::local.ar_name_status_required'),
            'en_name_status.required'       => trans('student::local.en_name_status_required'),            
            'sort.required'                 => trans('student::local.sort_required'),            
            'sort.numeric'                  => trans('student::local.sort_numeric'),

        ];
    }
}
