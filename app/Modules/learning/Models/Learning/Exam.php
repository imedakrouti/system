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
}
