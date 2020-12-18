<?php

namespace Learning\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
            'post_text'         => 'required',
            'classroom_id'      => 'required',            
            'youtube_url'       => 'max:200',
            'url'               => 'max:200',
            'description'       => 'max:200',
            'file_name'         => 'file|mimes:pdf,doc,docx,xls,xlsx,ppt,jpeg,png,jpg|max:1024',
        ];
    }
    public function messages()
    {
        return [
            'post_text.required'        => trans('learning::local.post_text_required'),            
            'classroom_id.required'     => trans('learning::local.classroom_id_required'),
            'youtube_url.max'           => trans('learning::local.youtube_url_max_200'),            
            'url.max'                   => trans('learning::local.url_max_200'),            
            'description.max'           => trans('learning::local.description_max_200'),            
            
        ];
    }
}
