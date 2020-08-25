<?php

namespace Student\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DivisionRequest extends FormRequest
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
            'ar_division_name'  => 'required',
            'en_division_name'  => 'required',
            'sort'              => 'required'
        ];
    }
    public function messages()
    {
        return [
            'ar_division_name.required'   => trans('student::local.ar_division_name_required'),
            'en_division_name.required'   => trans('student::local.en_division_name_required'),
            'sort.required'               => trans('student::local.sort_required')
        ];
    }
}
