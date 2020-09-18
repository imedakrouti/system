<?php

namespace Student\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MotherRequest extends FormRequest
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
        $id = request()->segment(5);
        return [
            'full_name'             => 'required',
            'id_type_m'             => 'required',
            'id_number_m'           => 'required|max:15|unique:mothers,id_number_m,'.$id,
            'religion_m'            => 'required',
            'nationality_id_m'      => 'required',
            'mobile1_m'             => 'required|max:11|unique:mothers,mobile1_m,'.$id,
            'mobile2_m'             => 'max:11|unique:mothers,mobile2_m,'.$id,
            'job_m'                 => 'required|max:75',
            'qualification_m'       => 'required|max:75',
            'block_no_m'            => 'required',
            'street_name_m'         => 'required|max:50',
            'state_m'               => 'required|max:30',
            'government_m'          => 'required|max:30',
            'email_m'               => 'max:75|unique:mothers,email_m,'.$id,      
            'facebook_m'            => 'max:50',
            'whatsapp_number_m'     => 'max:11',
        ];
    }
    public function messages()
    {
        return [           
            'full_name.required'                  => trans('student::local.full_name_required'),            
            'id_type_m.required'                  => trans('student::local.id_type_m_required'),            
            'id_number_m.required'                => trans('student::local.id_number_m_required'),
            'id_number_m.max'                     => trans('student::local.id_number_m_max'),
            'id_number_m.unique'                  => trans('student::local.id_number_m_uniqid'),
            'religion_m.required'                 => trans('student::local.religion_m_required'),
            'nationality_id_m.required'           => trans('student::local.nationality_id_m_required'),
            'home_phone_m.max'                    => trans('student::local.home_phone_m_max'),
            'mobile1_m.required'                  => trans('student::local.mobile1_m_required'),
            'mobile1_m.max'                       => trans('student::local.mobile1_m_max'),
            'mobile1_m.unique'                    => trans('student::local.mobile1_m_unique'),
            'mobile2_m.max'                       => trans('student::local.mobile2_m_max'),
            'mobile2_m.unique'                    => trans('student::local.mobile2_m_unique'),
            'job_m.required'                      => trans('student::local.job_m_required'),
            'job_m.max'                           => trans('student::local.job_m_max'),
            'qualification_m.required'            => trans('student::local.qualification_m_required'),
            'qualification_m.max'                 => trans('student::local.qualification_m_max'),
            'block_no_m.required'                 => trans('student::local.block_no_m_required'),
            'street_name_m.required'              => trans('student::local.street_name_m_required'),
            'street_name_m.max'                   => trans('student::local.street_name_m_max'),
            'state_m.required'                    => trans('student::local.state_m_required'),
            'state_m.max'                         => trans('student::local.state_m_max'),
            'government_m.required'               => trans('student::local.government_m_required'),
            'government_m.max'                    => trans('student::local.government_m_max'),            
            'facebook_m.max'                      => trans('student::local.facebook_m_max'),
            'whatsapp_number_m.max'               => trans('student::local.whatsapp_number_m_max'),
            'email_m.max'                         => trans('student::local.email_m_max'),
            'email_m.unique'                      => trans('student::local.email_m_uniqid')
        ];
    }
}
