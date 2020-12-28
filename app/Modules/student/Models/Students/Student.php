<?php

namespace Student\Models\Students;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

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
        'siblings',
        'twins',
        'user_id',

    ];
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setConnection(session('connection')); // see config/database.php where you have specified this second connection to a different DB
    }
    public function admin()
    {
        return $this->belongsTo('App\Models\Admin', 'admin_id');
    }
    public function nationalities()
    {
        return $this->belongsTo('Student\Models\Settings\Nationality', 'nationality_id');
    }
    public function regStatus()
    {
        return $this->belongsTo('Student\Models\Settings\RegistrationStatus', 'registration_status_id');
    }
    public function division()
    {
        return $this->belongsTo('Student\Models\Settings\Division', 'division_id')->orderBy('sort', 'asc');
    }
    public function father()
    {
        return $this->belongsTo('Student\Models\Parents\Father', 'father_id');
    }
    public function mother()
    {
        return $this->belongsTo('Student\Models\Parents\Mother', 'mother_id');
    }
    public function grade()
    {
        return $this->belongsTo('Student\Models\Settings\Grade', 'grade_id')->orderBy('sort', 'asc');
    }
    public function medical()
    {
        return $this->hasOne('Student\Models\Students\Medical', 'student_id');
    }
    public function addresses()
    {
        return $this->hasMany('Student\Models\Students\Address', 'student_id');
    }
    public function getStudentTypeAttribute()
    {
        return $this->attributes['student_type'] == 'student' ? trans('student::local.student') : trans('student::local.applicant');
    }
    public function guardian()
    {
        return $this->belongsTo('Student\Models\Guardians\Guardian', 'guardian_id');
    }
    public function employee()
    {
        return $this->belongsTo('App\Models\Admin', 'employee_id');
    }
    public function assessments()
    {
        return $this->hasMany('Student\Models\Admissions\Assessment', 'student_id');
    }
    public function statements()
    {
        return $this->hasMany('Student\Models\Students\StudentStatement', 'student_id');
    }
    public function getGenderAttribute()
    {
        return $this->attributes['gender'] == 'male' ? trans('student::local.male') : trans('student::local.female');
    }
    public function getReligionAttribute()
    {
        if ($this->attributes['gender'] == 'male') {
            return $this->attributes['religion'] == 'muslim' ? trans('student::local.muslim') : trans('student::local.non_muslim');
        } else {
            return $this->attributes['religion'] == 'muslim' ? trans('student::local.muslim_m') : trans('student::local.non_muslim_m');
        }
    }
    public function scopeStudent($q)
    {
        return $q->where('student_type', 'student');
    }
    public function native()
    {
        return $this->belongsTo('Student\Models\Settings\Language', 'native_lang_id');
    }
    public function languages()
    {
        return $this->belongsTo('Student\Models\Settings\Language', 'second_lang_id');
    }
    public function rooms()
    {
        return $this->hasMany('Student\Models\Students\Room', 'student_id');
    }
    public function classrooms()
    {
        return $this->belongsToMany('Student\Models\Settings\Classroom', 'rooms', 'student_id', 'classroom_id');
    }
    public function leaveRequests()
    {
        return $this->hasMany('Student\Models\Students\LeaveRequest', 'student_id');
    }
    public function transfers()
    {
        return $this->hasMany('Student\Models\Students\Transfer', 'student_id');
    }
    public function absence()
    {
        return $this->hasMany('Student\Models\Students\Absence', 'student_id');
    }
    public function getRegTypeAttribute()
    {
        switch ($this->attributes['reg_type']) {
            case 'new':
                return trans('student::local.new');
                break;
            case 'transfer':
                return trans('student::local.transfer');
                break;
            case 'arrival':
                return trans('student::local.arrival');
                break;
            default:
                return trans('student::local.return');
                break;
        }
    }
    public function setEnStudentNameAttribute($value)
    {
        return $this->attributes['en_student_name'] = ucfirst($value);
    }
    public function subjects()
    {
        return $this->belongsToMany('Learning\Models\Settings\Subject', 'student_subject', 'student_id', 'subject_id');
    }
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
    // get full name for student
    public function getStudentNameAttribute()
    {
        if (session('lang') == 'ar') {
            return $this->ar_student_name . ' ' . $this->father->ar_st_name . ' ' . $this->father->ar_nd_name . ' ' . $this->father->ar_rd_name;
        } else {
            return $this->en_student_name . ' ' . $this->father->en_st_name . ' ' . $this->father->en_nd_name . ' ' . $this->father->en_rd_name;
        }
    }
    // name for student
    public function getStudentShortNameAttribute()
    {
        if (session('lang') == 'ar') {
            return $this->ar_student_name . ' ' . $this->father->ar_st_name;
        } else {
            return $this->en_student_name . ' ' . $this->father->en_st_name;
        }
    }
    // get full name for student and student number
    public function getNationalityAttribute()
    {
        if (session('lang') == 'ar') {
            if ($this->gender == trans('student::local.male')) {
                return $this->nationalities->ar_name_nat_male;                
            }else{
                return $this->nationalities->ar_name_nat_female;                
            }
        } else {
            return $this->nationalities->en_name_nationality;
        }
    }

    public function getShowStudentAttribute()
    {        
        if ($this->student_image) {
            return 'images/studentsImages/' . $this->student_image;
        }
        return $this->gender == trans('student::local.male') ?
        'images/studentsImages/37.jpeg' : 'images/studentsImages/39.png';
    }

    public function scopeSort($q)
    {
        return $q->orderBy('ar_student_name');
    }

    public function behaviours()
    {
        return $this->hasMany('Learning\Models\Learning\Behaviour','student_id')->orderBy('month_id');
    }
}
