<?php

namespace Staff\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
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
        $id = request()->segment(3);
        return [
            'ar_st_name'     => 'required|max:15',
            'ar_nd_name'     => 'required|max:15',
            'en_st_name'     => 'required|max:15',
            'en_nd_name'     => 'required|max:15',
            'attendance_id'  => 'required|unique:employees,attendance_id,'.$id,
            'national_id'    => 'required|max:15|unique:employees,national_id,'.$id,
            'salary'         => 'required|numeric',
            'leave_balance'  => 'required|numeric',
            'employee_image' => 'image|mimes:jpeg,png,jpg|max:1024',            
        ];
    }
    public function messages()
    {
        return [
            'ar_st_name.required'           => trans('staff::local.ar_st_name_required'),
            'ar_st_name.max'                => trans('staff::local.ar_st_name_max'),
            'ar_nd_name.required'           => trans('staff::local.ar_nd_name_required'),
            'ar_nd_name.max'                => trans('staff::local.ar_nd_name_max'),
            'en_st_name.required'           => trans('staff::local.en_st_name_required'),
            'en_st_name.max'                => trans('staff::local.en_st_name_max'),
            'en_nd_name.required'           => trans('staff::local.en_nd_name_required'),
            'en_nd_name.max'                => trans('staff::local.en_nd_name_max'),
            'attendance_id.required'        => trans('staff::local.attendance_id_required'),
            'attendance_id.unique'          => trans('staff::local.attendance_id_unique'),
            'national_id.required'          => trans('staff::local.national_id_required'),
            'national_id.unique'            => trans('staff::local.national_id_unique'),
            'national_id.max'               => trans('staff::local.national_id_max'),
            'salary.required'               => trans('staff::local.salary_required'),
            'salary.numeric'                => trans('staff::local.salary_numeric'),
            'leave_balance.required'        => trans('staff::local.leave_balance_required'),
            'leave_balance.numeric'         => trans('staff::local.leave_balance_numeric'),



            
        ];
    }
}
