<?php

namespace Student\Models\Students;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    protected $table = 'transfers';

    protected $fillable = [
        'leaved_date',
        'leave_reason',
        'school_fees',
        'school_books',
        'school_id',
        'current_grade_id',
        'next_grade_id',
        'current_year_id',
        'next_year_id',
        'student_id',
        'admin_id',     
    ];
    public function __construct(Array $attributes = [])
    {
        parent::__construct($attributes);
        
        $this->setConnection(session('connection')); // see config/database.php where you have specified this second connection to a different DB
    }
    public function admin()
    {
        return $this->belongsTo('App\Models\Admin','admin_id');
    }
    public function students()
    {
        return $this->belongsTo('Student\Models\Students\Student','student_id');
    }
    public function currentGrade()
    {
        return $this->belongsTo('Student\Models\Settings\Grade','current_grade_id');
    } 
    public function nextGrade()
    {
        return $this->belongsTo('Student\Models\Settings\Grade','next_grade_id');
    } 
    public function currentYear()
    {
        return $this->belongsTo('Student\Models\Settings\Year','current_year_id');
    } 
    public function nextYear()
    {
        return $this->belongsTo('Student\Models\Settings\Year','next_year_id');
    }   
    public function schools()
    {
        return $this->belongsTo('Student\Models\Settings\School','school_id');
    }    
    public function getSchoolFeesAttribute()
    {
        return $this->attributes['school_fees'] == 'payed' ? trans('student::local.payed') : trans('student::local.not_payed');
    }     
    public function getSchoolBooksAttribute()
    {
        return $this->attributes['school_books'] == 'received' ? trans('student::local.received') : trans('student::local.not_received');
    }            
}
