<?php

namespace Staff\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LeaveTypeRequest extends FormRequest
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
            'ar_leave'     => 'required|max:50',
            'en_leave'     => 'required|max:50',
            'sort'         => 'required'
        ];
    }
    public function messages()
    {
        return [
            'ar_leave.required'         => trans('staff::local.ar_leave_required'),
            'ar_leave.max'              => trans('staff::local.ar_leave_max'),
            'en_leave.required'         => trans('staff::local.en_leave_required'),
            'en_leave.max'              => trans('staff::local.en_leave_max'),
            'sort.required'             => trans('staff::local.sort_required')
        ];
    }
}
