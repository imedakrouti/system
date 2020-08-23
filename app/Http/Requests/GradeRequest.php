<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GradeRequest extends FormRequest
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
            'ar_grade_name'         => 'required',
            'en_grade_name'         => 'required',
            'ar_grade_parent'       => 'required',
            'en_grade_parent'       => 'required',
            'from_age_year'         => 'required|numeric',
            'from_age_month'        => 'required|numeric',
            'to_age_year'           => 'required|numeric',
            'to_age_month'          => 'required|numeric',
            'sort'                  => 'required|numeric'
        ];
    }
    public function messages()
    {
        return [
            'ar_grade_name.required'        => trans('student::local.ar_grade_name_required'),
            'en_grade_name.required'        => trans('student::local.en_grade_name_required'),
            'ar_grade_parent.required'      => trans('student::local.ar_grade_parent_required'),
            'en_grade_parent.required'      => trans('student::local.en_grade_parent_required'),
            'from_age_year.required'        => trans('student::local.from_age_year_required'),
            'from_age_month.required'       => trans('student::local.from_age_month_required'),
            'to_age_year.required'          => trans('student::local.to_age_year_required'),
            'to_age_month.required'         => trans('student::local.to_age_month_required'),
            'sort.required'                 => trans('student::local.sort_required'),
            'from_age_year.numeric'         => trans('student::local.from_age_year_numeric'),
            'from_age_month.numeric'        => trans('student::local.from_age_month_numeric'),
            'to_age_year.numeric'           => trans('student::local.to_age_year_numeric'),
            'to_age_month.numeric'          => trans('student::local.to_age_month_numeric'),
            'sort.numeric'                  => trans('student::local.sort_numeric'),

        ];
    }
}
