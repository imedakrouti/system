<?php

namespace Staff\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TimetableRequest extends FormRequest
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
            'ar_timetable'     => 'required|max:50',
            'en_timetable'     => 'required|max:50',            
        ];
    }
    public function messages()
    {
        return [
            'ar_timetable.required'         => trans('staff::local.ar_timetable_required'),
            'ar_timetable.max'              => trans('staff::local.ar_timetable_max'),
            'en_timetable.required'         => trans('staff::local.en_timetable_required'),
            'en_timetable.max'              => trans('staff::local.en_timetable_max')            
        ];
    }
}
