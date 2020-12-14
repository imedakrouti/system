<?php

namespace Learning\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExamRequest extends FormRequest
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
            'exam_name'                 => 'required|max:50',
            'start_date'                => 'required',
            'start_time'                => 'required',
            'end_date'                  => 'required',
            'end_time'                  => 'required',
            'duration'                  => 'required',
            'total_mark'                => 'required',
            'no_question_per_page'      => 'required'
        ];
    }
    public function messages()
    {
        return [
            'exam_name.required'                => trans('learning::local.exam_name_required'),
            'exam_name.max'                     => trans('learning::local.exam_name_max_50'),
            'start_date.required'               => trans('learning::local.start_date_required'),
            'start_time.required'               => trans('learning::local.start_time_required'),
            'end_date.required'                 => trans('learning::local.end_date_required'),
            'end_time.required'                 => trans('learning::local.end_time_required'),
            'duration.required'                 => trans('learning::local.duration_required'),
            'total_mark.required'               => trans('learning::local.total_mark_required'),
            'no_question_per_page.required'     => trans('learning::local.no_question_per_page_required'),

        ];
    }
}
