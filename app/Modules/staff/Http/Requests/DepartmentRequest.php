<?php

namespace Staff\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DepartmentRequest extends FormRequest
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
            'ar_department'     => 'required|max:25',
            'en_department'     => 'required|max:25',
            'sector_id'         => 'required',
            'leave_allocate'    => 'required',
            'sort'              => 'required'
        ];
    }
    public function messages()
    {
        return [
            'ar_department.required'         => trans('staff::local.ar_department_required'),
            'ar_department.max'              => trans('staff::local.ar_department_max'),
            'en_department.required'         => trans('staff::local.en_department_required'),
            'en_department.max'              => trans('staff::local.en_department_max'),
            'leave_allocate.max'             => trans('staff::local.leave_allocate_max'),
            'sort.required'                  => trans('staff::local.sort_required')
        ];
    }
}
