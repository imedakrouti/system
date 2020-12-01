<?php

namespace Learning\Models\Learning;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $fillable = [
        'exam_name',
        'start_date',
        'start_time',
        'end_date',
        'end_time',
        'duration',
        'total_mark',                
        'no_question_per_page',                
        'description', 
        'subject_id',         
        'auto_correct',
        'show_results',
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
    public function subjects()
    {
        return $this->belongsTo('Learning\Models\Settings\Subject','subject_id');
    }
    public function lessons()
    {
        return $this->belongsToMany('Learning\Models\Learning\Lesson','lesson_exam','exam_id','lesson_id');
    }
    public function divisions()
    {
        return $this->belongsToMany('Student\Models\Settings\Division','exam_division','exam_id','division_id');
    }
    public function grades()
    {
        return $this->belongsToMany('Student\Models\Settings\Grade','exam_grade','exam_id','grade_id');
    }
    public function classrooms()
    {
        return $this->belongsToMany('Student\Models\Settings\Classroom','exam_classroom','exam_id','classroom_id');
    }
    public function questions()
    {
        return $this->hasMany('Learning\Models\Learning\Question','exam_id');
    }
    public function userAnswers()
    {
        return $this->hasMany('Learning\Models\Learning\UserAnswer','exam_id');
    }
   
    public function userExams()
    {        
        return $this->hasMany('Learning\Models\Learning\UserExam','exam_id');        
    }
}
