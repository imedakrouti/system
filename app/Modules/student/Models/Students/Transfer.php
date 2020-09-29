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
}
