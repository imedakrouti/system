<?php

namespace Staff\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DocumentRequest extends FormRequest
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
            'ar_document'     => 'required|max:25',
            'en_document'     => 'required|max:25',
            'sort'            => 'required'
        ];
    }
    public function messages()
    {
        return [
            'ar_document.required'         => trans('staff::local.ar_document_required'),
            'ar_document.max'              => trans('staff::local.ar_document_max'),
            'en_document.required'         => trans('staff::local.en_document_required'),
            'en_document.max'              => trans('staff::local.en_document_max'),
            'sort.required'                => trans('staff::local.sort_required')
        ];
    }
}
