<?php

namespace Staff\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MachineRequest extends FormRequest
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
            'device_name'     => 'required|max:30',            
            'ip_address'      => 'required',
            'port'            => 'required'
        ];
    }
    public function messages()
    {
        return [
            'device_name.required'         => trans('staff::local.device_name_required'),
            'device_name.max'              => trans('staff::local.device_name_max'),            
            'ip_address.required'          => trans('staff::local.ip_address_required'),            
            'port.required'                => trans('staff::local.port_required')
        ];
    }
}
