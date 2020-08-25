<?php

namespace Student\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class YearRequest extends FormRequest
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
            'name'          => 'required',
            'start_from'    => 'required',
            'end_from'      => 'required'
        ];
    }
    public function messages()
    {
        return [
            'name.required'         => trans('student::local.name_required'),
            'start_from.required'   => trans('student::local.start_from_required'),
            'end_from.required'     => trans('student::local.end_from_required')
        ];
    }
}
