<?php

namespace Student\Models\Students;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'father_id',
        'mother_id',
        'employee_id',
        'student_type',
        'ar_student_name',
        'en_student_name',
        'student_id_number',
        'student_id_type',
        'student_number',
        'gender',
        'nationality_id',
        'religion',
        'native_lang_id',
        'second_lang_id',
        'term',
        'dob',
        'code',
        'reg_type',
        'grade_id',
        'division_id',
        'student_image',
        'submitted_application',
        'submitted_name',
        'submitted_id_number',
        'submitted_mobile',
        'school_id',
        'transfer_reason',
        'application_date',
        'guardian_id',
        'place_birth',
        'return_country',
        'registration_status_id',
        'year_id',
        'admin_id',
    
    ];
    public function admin()
    {
        return $this->belongsTo('App\Models\Admin','admin_id');
    }
    public function nationalities()
    {
        return $this->belongsTo('Student\Models\Settings\Nationality','nationality_id');
    }
    public function regStatus()
    {
        return $this->belongsTo('Student\Models\Settings\RegistrationStatus','registration_status_id');
    }
    public function division()
    {
        return $this->belongsTo('Student\Models\Settings\Division','division_id');
    }
    public function father()
    {
        return $this->belongsTo('Student\Models\Parents\Father','father_id');
    }
    public function mother()
    {
        return $this->belongsTo('Student\Models\Parents\Mother','mother_id');
    }
    public function grade()
    {
        return $this->belongsTo('Student\Models\Settings\Grade','grade_id');
    }
    public function medical()
    {
        return $this->hasOne('Student\Models\Students\Medical','student_id');
    }
    public function addresses()
    {
        return $this->hasMany('Student\Models\Students\Address','student_id');
    }
    public function getStudentTypeAttribute()
    {
        return $this->attributes['student_type'] == 'student' ? trans('student::local.student') : trans('student::local.applicant');
    }
    public function guardian()
    {
        return $this->belongsTo('Student\Models\Guardians\Guardian','guardian_id');
    }
    public function employee()
    {
        return $this->belongsTo('App\Models\Admin','employee_id');
    }
    public function assessments()
    {
        return $this->hasMany('Student\Models\Admissions\Assessment','student_id');
    }

}
