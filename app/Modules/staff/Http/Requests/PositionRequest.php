<?php

namespace Staff\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PositionRequest extends FormRequest
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
            'ar_position'     => 'required|max:25',
            'en_position'     => 'required|max:25',
            'sort'            => 'required'
        ];
    }
    public function messages()
    {
        return [
            'ar_position.required'         => trans('staff::local.ar_position_required'),
            'ar_position.max'              => trans('staff::local.ar_position_max'),
            'en_position.required'         => trans('staff::local.en_position_required'),
            'en_position.max'              => trans('staff::local.en_position_max'),
            'sort.required'                => trans('staff::local.sort_required')
        ];
    }
}
