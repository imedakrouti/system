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
            // rules
            'arabicSector'           => 'required',
            'englishSector'          => 'required',
            'sort'          		 => 'numeric',
        ];
    }
    public function messages()
    {
        return [
            // message
            'arabicSector.required'   => trans('staff::admin.arabic_sector_required'),
            'englishSector.required'  => trans('staff::admin.english_sector_required'),
            'sort.numeric'  		  => trans('staff::admin.sort_numeric'),
        ];
    }
}
