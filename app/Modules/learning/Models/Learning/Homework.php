<?php

namespace Learning\Models\Learning;

use Illuminate\Database\Eloquent\Model;

class Homework extends Model
{
    protected $table = "homeworks";
    protected $fillable = [
        'title',
        'due_date',
        'instruction',
        'file_name',
        'subject_id',
        'admin_id',
        'total_mark',
        'correct'
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
    public function subject()
    {
        return $this->belongsTo('Learning\Models\Settings\Subject', 'subject_id');
    }
    public function lessons()
    {
        return $this->belongsToMany('Learning\Models\Learning\Lesson', 'lesson_homework', 'homework_id', 'lesson_id');
    }
    public function classrooms()
    {
        return $this->belongsToMany('Student\Models\Settings\Classroom', 'classroom_homework', 'homework_id', 'classroom_id');
    }
    public function deliverHomeworks()
    {
        return $this->hasMany('Learning\Models\Learning\DeliverHomework', 'homework_id');
    }
    public function questions()
    {
        return $this->hasMany('Learning\Models\Learning\Question', 'homework_id');
    }
}
