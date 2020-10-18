<?php

namespace Staff\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SalaryComponentRequest extends FormRequest
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
            'ar_item'     => 'required|max:25',
            'en_item'     => 'required|max:25',
            'sort'        => 'required',
            'formula'        => 'required'
        ];
    }
    public function messages()
    {
        return [
            'ar_item.required'         => trans('staff::local.ar_item_required'),
            'ar_item.max'              => trans('staff::local.ar_item_max'),
            'en_item.required'         => trans('staff::local.en_item_required'),
            'en_item.max'              => trans('staff::local.en_item_max'),
            'sort.required'            => trans('staff::local.sort_required'),
            'formula.required'         => trans('staff::local.formula_required')
        ];
    }
}
