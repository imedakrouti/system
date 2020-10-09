<?php

namespace Student\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FatherRequest extends FormRequest
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
            'ar_st_name'            => 'required|max:30',
            'ar_nd_name'            => 'required|max:30',
            'ar_rd_name'            => 'required|max:30',
            'ar_th_name'            => 'required|max:30',
            'en_st_name'            => 'required|max:30',
            'en_nd_name'            => 'required|max:30',
            'en_rd_name'            => 'required|max:30',
            'en_th_name'            => 'required|max:30',
            'id_type'               => 'required',
            'id_number'             => 'required|max:15|unique:fathers,id_number,'.$id,
            'religion'              => 'required',
            'nationality_id'        => 'required',
            'home_phone'            => 'max:11',
            'mobile1'               => 'required|max:11|unique:fathers,mobile1,'.$id,
            'mobile2'               => 'max:11',
            'job'                   => 'required|max:75',
            'qualification'         => 'required|max:75',
            'block_no'              => 'required',
            'street_name'           => 'required|max:50',
            'state'                 => 'required|max:30',
            'government'            => 'required|max:30',
            'educational_mandate'   => 'required',
            'marital_status'        => 'required',
            'facebook'              => 'max:50',
            'whatsapp_number'       => 'max:11',
            'email'                 => 'max:75',
        ];
    }
    public function messages()
    {
        return [
            'ar_st_name.required'               => trans('student::local.ar_st_name_required'),
            'ar_nd_name.required'               => trans('student::local.ar_nd_name_required'),
            'ar_rd_name.required'               => trans('student::local.ar_rd_name_required'),
            'ar_th_name.required'               => trans('student::local.ar_th_name_required'),
            'en_st_name.required'               => trans('student::local.en_st_name_required'),
            'en_nd_name.required'               => trans('student::local.en_nd_name_required'),
            'en_rd_name.required'               => trans('student::local.en_rd_name_required'),
            'en_th_name.required'               => trans('student::local.en_th_name_required'),
            'ar_st_name.max'                    => trans('student::local.ar_st_name_max'),
            'ar_nd_name.max'                    => trans('student::local.ar_nd_name_max'),
            'ar_rd_name.max'                    => trans('student::local.ar_rd_name_max'),
            'ar_th_name.max'                    => trans('student::local.ar_th_name_max'),
            'en_st_name.max'                    => trans('student::local.en_st_name_max'),
            'en_nd_name.max'                    => trans('student::local.en_nd_name_max'),
            'en_rd_name.max'                    => trans('student::local.en_rd_name_max'),
            'en_th_name.max'                    => trans('student::local.en_th_name_max'),
            'id_type.required'                  => trans('student::local.id_type_required'),            
            'id_number.required'                => trans('student::local.id_number_required'),
            'id_number.unique'                  => trans('student::local.id_number_unique'),
            'id_number.max'                     => trans('student::local.id_number_max'),
            'religion.required'                 => trans('student::local.religion_required'),
            'nationality_id.required'           => trans('student::local.nationality_id_required'),
            'home_phone.max'                    => trans('student::local.home_phone_max'),
            'mobile1.required'                  => trans('student::local.mobile1_required'),
            'mobile1.unique'                    => trans('student::local.mobile1_unique'),
            'mobile1.max'                       => trans('student::local.mobile1_max'),
            'mobile2.max'                       => trans('student::local.mobile2_max'),            
            'job.required'                      => trans('student::local.job_required'),
            'job.max'                           => trans('student::local.job_max'),
            'qualification.required'            => trans('student::local.qualification_required'),
            'qualification.max'                 => trans('student::local.qualification_max'),
            'block_no.required'                 => trans('student::local.block_no_required'),
            'street_name.required'              => trans('student::local.street_name_required'),
            'street_name.max'                   => trans('student::local.street_name_max'),
            'state.required'                    => trans('student::local.state_required'),
            'state.max'                         => trans('student::local.state_max'),
            'government.required'               => trans('student::local.government_required'),
            'government.max'                    => trans('student::local.government_max'),
            'educational_mandate.required'      => trans('student::local.educational_mandate_required'),
            'marital_status.required'           => trans('student::local.marital_status_required'),
            'facebook.max'                      => trans('student::local.facebook_max'),
            'whatsapp_number.max'               => trans('student::local.whatsapp_number_max'),
            'email.max'                         => trans('student::local.email_max'),            
        ];
    }
}
