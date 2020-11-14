<?php

namespace Learning\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubjectRequest extends FormRequest
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
            'ar_name'          => 'required|max:30',
            'en_name'          => 'required|max:30',
            'division_id'      => 'required',
            'grade_id'         => 'required',
            'sort'             => 'required'
        ];
    }
    public function messages()
    {
        return [
            'ar_name.required'          => trans('learning::local.ar_name_required'),
            'ar_name.max'               => trans('learning::local.ar_name_max'),
            'en_name.required'          => trans('learning::local.en_name_required'),
            'en_name.max'               => trans('learning::local.en_name_max'),
            'division_id.required'      => trans('learning::local.division_id_required'),
            'grade_id.required'         => trans('learning::local.grade_id_required'),
            'sort.required'             => trans('learning::local.sort_required'),
            
        ];
    }
}
