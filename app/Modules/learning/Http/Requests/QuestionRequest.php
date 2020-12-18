<?php

namespace Learning\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionRequest extends FormRequest
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
            'question_text'     => 'required|max:75',
            'mark'              => 'required|numeric',
            'file_name'         => 'file|mimes:jpeg,png,jpg|max:1024',
        ];
    }

    public function messages()
    {
        return [
            'question_text.required'        => trans('learning::local.question_text_required'),
            'question_text.max'             => trans('learning::local.question_text_max_75'),  
            'mark.required'                 => trans('learning::local.mark_required'),
            'mark.numeric'                  => trans('learning::local.mark_numeric_75'),            
        ];
    }
}
