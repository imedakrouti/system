<?php

namespace Learning\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LessonRequest extends FormRequest
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
            'lesson_title'     => 'required|max:75',
            'division_id'      => 'required',            
            'grade_id'         => 'required',            
            'sort'             => 'required',
            'file_name'        => 'mimetypes:video/avi,video/mpeg,video/quicktime|max:5000',
        ];
    }
    public function messages()
    {
        return [
            'lesson_title.required'     => trans('learning::local.lesson_title_required'),
            'lesson_title.max'          => trans('learning::local.lesson_title_max_75'),
            'division_id.required'      => trans('learning::local.division_id_required'),
            'grade_id.required'         => trans('learning::local.grade_id_required'),            
            'sort.required'             => trans('learning::local.sort_required'),
            
        ];
    }
}
