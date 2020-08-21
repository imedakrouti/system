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
            // rules
            'arabicDepartment'           => 'required',
            'englishDepartment'          => 'required',
            'balanceDepartmentLeave'     => 'required|numeric',
            'sort'          		     => 'numeric',
        ];
    }
    public function messages()
    {
        return [
            // message
            'arabicDepartment.required'         => trans('staff::admin.arabic_department_required'),
            'englishDepartment.required'        => trans('staff::admin.english_department_required'),
            'balanceDepartmentLeave.required'   => trans('staff::admin.balance_department_required'),
            'balanceDepartmentLeave.numeric'    => trans('staff::admin.balance_department_numeric'),
            'sort.numeric'  		            => trans('staff::admin.sort_numeric'),
        ];
    }
}
