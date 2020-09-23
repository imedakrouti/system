<?php

namespace Student\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommissionerRequest extends FormRequest
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
        $id = request()->segment(3);
        return [
            'commissioner_name'     => 'required|max:100',            
            'id_number'             => 'required|max:15|unique:commissioners,id_number,'.$id,            
            'mobile'                => 'required|max:11|unique:commissioners,mobile,'.$id            
        ];
    }
    public function messages()
    {
        return [            
           'commissioner_name.required'         => trans('student::local.commissioner_name_required'),
           'commissioner_name.max'              => trans('student::local.commissioner_name_max'),
           'id_number.required'                 => trans('student::local.id_number_required'),
           'id_number.unique'                   => trans('student::local.id_number_unique'),
           'id_number.max'                      => trans('student::local.id_number_max'),
           'mobile.required'                    => trans('student::local.mobile_required'),
           'mobile.max'                         => trans('student::local.mobile_max'),
           'mobile.unique'                      => trans('student::local.mobile_unique'),
        ];
    }    
}
