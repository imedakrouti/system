<?php

namespace Student\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SchoolRequest extends FormRequest
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
            'school_name'              => 'required|max:50',
            'school_government'        => 'required|max:30',
            'school_address'           => 'required',
            'school_type'              => 'required'
        ];
    }
    public function messages()
    {
        return [
            'school_name.required'             => trans('student::local.school_name_required'),
            'school_name.max'             => trans('student::local.school_name_max'),
            'school_government.required'       => trans('student::local.school_government_required'),
            'school_government.max'       => trans('student::local.school_government_max'),
            'school_address.required'          => trans('student::local.school_address_required'),
            'school_type.required'             => trans('student::local.school_type_required')
        ];
    }
}
