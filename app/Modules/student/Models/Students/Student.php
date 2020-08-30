<?php

namespace Student\Models\Students;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'student_type',
        'ar_student_name',
        'en_student_name',
        'id_type',
        'id_number',
        'gender',
        'religion',
        'native_lang_id',
        'second_lang_id',
        'term',
        'dob',
        'reg_type',
        'student_image',
        'submitted_application',
        'submitted_name',
        'submitted_id_number',
        'submitted_mobile',
        'application_date',
        'liveWith',
        'grade_id',
        'division_id',
        'registration_status_id',
        'nationality_id',
        'father_id',
        'mother_id',
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

}
