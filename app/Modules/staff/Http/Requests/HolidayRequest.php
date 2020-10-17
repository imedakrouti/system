<?php

namespace Staff\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HolidayRequest extends FormRequest
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
            'ar_holiday'     => 'required|max:25',
            'en_holiday'     => 'required|max:25',
            'description'    => 'required|max:100',
            'sort'            => 'required'
        ];
    }
    public function messages()
    {
        return [
            'ar_holiday.required'         => trans('staff::local.ar_holiday_required'),
            'ar_holiday.max'              => trans('staff::local.ar_holiday_max'),
            'en_holiday.required'         => trans('staff::local.en_holiday_required'),
            'en_holiday.max'              => trans('staff::local.en_holiday_max'),
            'description.required'        => trans('staff::local.description_required'),
            'description.max'             => trans('staff::local.description_max'),
            'sort.required'               => trans('staff::local.sort_required')
        ];
    }
}
