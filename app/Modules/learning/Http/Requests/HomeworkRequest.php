<?php

namespace Learning\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HomeworkRequest extends FormRequest
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
            'title'         => 'required|max:75',
            'file_name'     => 'file|mimes:pdf,doc,docx,xls,xlsx,ppt,jpeg,png,jpg|max:1024',
        ];
    }

    public function messages()
    {
        return [
            'title.required'        => trans('learning::local.title_required'),
            'title.max'             => trans('learning::local.title_max_75'),            
        ];
    }
}
