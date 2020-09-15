<?php

namespace Student\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
        $id = request()->segment(2);
        return [
            'relative_name'         => 'required',
            'relative_mobile'       => 'required|numeric|unique:contacts,relative_mobile,'.$id            
        ];
    }
    public function messages()
    {
        return [
            'relative_name.required'     => trans('student::local.relative_name_required'),
            'relative_mobile.required'   => trans('student::local.relative_mobile_required'),            
            'relative_mobile.numeric'    => trans('student::local.relative_mobile_numeric'),            
            'relative_mobile.unique'     => trans('student::local.relative_mobile_unique'),            
        ];
    }
}
