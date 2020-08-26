<?php

namespace Student\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NationalityRequest extends FormRequest
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
            'ar_name_nat_male'     => 'required',
            'ar_name_nat_female'   => 'required',
            'en_name_nationality'  => 'required',
            'sort'                 => 'required'
        ];
    }
    public function messages()
    {
        return [
            'ar_name_nat_male.required'      => trans('student::local.ar_name_nat_male_required'),
            'ar_name_nat_female.required'    => trans('student::local.ar_name_nat_female_required'),
            'en_name_nationality.required'   => trans('student::local.en_name_nationality_required'),
            'sort.required'                  => trans('student::local.sort_required')
        ];
    }
}
