<?php

namespace Student\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GuardianRequest extends FormRequest
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
            'guardian_full_name'             => 'required|max:30',
            'guardian_id_type'               => 'required',
            'guardian_id_number'             => 'required|max:15|unique:guardians,guardian_id_number,'.$id,            
            'guardian_mobile1'               => 'required|max:11',
            'guardian_mobile2'               => 'max:11',
            'guardian_job'                   => 'required|max:75',            
            'guardian_block_no'              => 'required',
            'guardian_street_name'           => 'required|max:50',
            'guardian_state'                 => 'required|max:30',
            'guardian_government'            => 'required|max:30',            
            'guardian_email'                 => 'max:75|unique:guardians,guardian_email,'.$id,
        ];
    }
    public function messages()
    {
        return [            
           'guardian_full_name.max'                     => trans('student::local.guardian_full_name_max'),
           'guardian_id_type.required'                  => trans('student::local.guardian_id_type_required'),            
           'guardian_id_number.required'                => trans('student::local.guardian_id_number_required'),
           'guardian_id_number.unique'                  => trans('student::local.guardian_id_number_unique'),
           'guardian_id_number.max'                     => trans('student::local.guardian_id_number_max'),            
           'guardian_mobile1.required'                  => trans('student::local.guardian_mobile1_required'),
           'guardian_mobile1.max'                       => trans('student::local.guardian_mobile1_max'),
           'guardian_mobile2.max'                       => trans('student::local.guardian_mobile2_max'),
           'guardian_job.required'                      => trans('student::local.guardian_job_required'),
           'guardian_job.max'                           => trans('student::local.guardian_job_max'),            
           'guardian_block_no.required'                 => trans('student::local.guardian_block_no_required'),
           'guardian_street_name.required'              => trans('student::local.guardian_street_name_required'),
           'guardian_street_name.max'                   => trans('student::local.guardian_street_name_max'),
           'guardian_state.required'                    => trans('student::local.guardian_state_required'),
           'guardian_state.max'                         => trans('student::local.guardian_state_max'),
           'guardian_government.required'               => trans('student::local.guardian_government_required'),
           'guardian_government.max'                    => trans('student::local.guardian_government_max'),            
           'guardian_email.max'                         => trans('student::local.guardian_email_max'),
           'guardian_email.unique'                      => trans('student::local.guardian_email_unique')
        ];
    }
}
