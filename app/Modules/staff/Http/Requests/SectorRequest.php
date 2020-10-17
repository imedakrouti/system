<?php

namespace Staff\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SectorRequest extends FormRequest
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
            'ar_sector'     => 'required|max:25',
            'en_sector'     => 'required|max:25',
            'sort'          => 'required'
        ];
    }
    public function messages()
    {
        return [
            'ar_sector.required'         => trans('student::local.ar_sector_required'),
            'ar_sector.max'              => trans('student::local.ar_sector_max'),
            'en_sector.required'         => trans('student::local.en_sector_required'),
            'en_sector.max'              => trans('student::local.en_sector_max'),
            'sort.required'              => trans('student::local.sort_required')
        ];
    }
}
