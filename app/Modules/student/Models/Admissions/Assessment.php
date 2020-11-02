<?php

namespace Student\Models\Admissions;

use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{    
    protected $fillable = [
        'notes','student_id','admin_id','assessment_type','acceptance'
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
    public function tests()
    {
        return $this->hasMany('Student\Models\Admissions\Test','assessment_id');
    }
    public function students()
    {
        return $this->belongsTo('Student\Models\Students\Student','student_id');
    }
    public function getAcceptanceAttribute()
    {
        return $this->attributes['acceptance'] == 'accepted' ? trans('student::local.accepted') :
        trans('student::local.rejected');
    }
    public function getAssessmentTypeAttribute()
    {
        return $this->attributes['assessment_type'] == 'assessment' ? trans('student::local.assessment') :
        trans('student::local.re_assessment');
    }
}
