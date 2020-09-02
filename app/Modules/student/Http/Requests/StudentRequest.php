<?php

namespace Student\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
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
            'mother_id'             => 'required',
            'student_type'          => 'required',
            'ar_student_name'       => 'required',
            'en_student_name'       => 'required',
            'id_type'               => 'required',            
            'id_number'             => 'required|unique:students,id_number,'.$id,
            'gender'                => 'required',
            'nationality_id'        => 'required',
            'religion'              => 'required',
            'native_lang_id'        => 'required',
            'second_lang_id'        => 'required',
            'term'                  => 'required',
            'dob'                   => 'required',
            'reg_type'              => 'required',
            'grade_id'              => 'required',
            'division_id'           => 'required',
            'application_date'      => 'required',
            'registration_status_id'=> 'required',
        ];
    }
    public function messages()
    {
        return [
            'mother_id.required'                => trans('student::local.stu_mother_id_required'),
            'student_type.required'             => trans('student::local.stu_student_type_required'),
            'ar_student_name.required'          => trans('student::local.stu_ar_student_name_required'),
            'en_student_name.required'          => trans('student::local.stu_en_student_name_required'),
            'id_type.required'                  => trans('student::local.stu_id_type_required'),
            'id_number.required'                => trans('student::local.stu_id_number_required'),
            'id_number.unique'                  => trans('student::local.stu_id_number_unique'),
            'gender.required'                   => trans('student::local.stu_gender_required'),
            'nationality_id.required'           => trans('student::local.stu_nationality_id_required'),
            'religion.required'                 => trans('student::local.stu_religion_required'),
            'native_lang_id.required'           => trans('student::local.stu_native_lang_id_required'),
            'second_lang_id.required'           => trans('student::local.stu_second_lang_id_required'),
            'term.required'                     => trans('student::local.stu_term_required'),
            'dob.required'                      => trans('student::local.stu_dob_required'),
            'reg_type.required'                 => trans('student::local.stu_reg_type_required'),
            'grade_id.required'                 => trans('student::local.stu_grade_id_required'),
            'division_id.required'              => trans('student::local.stu_division_id_required'),
            'application_date.required'         => trans('student::local.stu_application_date_required'),
            'registration_status_id.required'   => trans('student::local.stu_reg_status_id_required'),
            
        ];
    }
}
