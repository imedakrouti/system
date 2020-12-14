<?php

namespace Learning\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlaylistRequest extends FormRequest
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
            'playlist_name'    => 'required|max:75',            
            'sort'             => 'required'
        ];
    }
    public function messages()
    {
        return [
            'playlist_name.required'    => trans('learning::local.playlist_name_required'),
            'playlist_name.max'         => trans('learning::local.playlist_name_max_75'),                   
            'sort.required'             => trans('learning::local.sort_required'),
            
        ];
    }
}
