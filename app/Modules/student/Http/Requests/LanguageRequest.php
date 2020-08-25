<?php

namespace Student\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LanguageRequest extends FormRequest
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
            'ar_name_lang'  => 'required',
            'en_name_lang'  => 'required',
            'sort'               => 'required'
        ];
    }
    public function messages()
    {
        return [
            'ar_name_lang.required'   => trans('student::local.ar_name_lang_required'),
            'en_name_lang.required'   => trans('student::local.en_name_lang_required'),
            'sort.required'                => trans('student::local.sort_required')
        ];
    }
}
