<?php

namespace Learning\Models\Learning;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'question_type',
        'question_text',
        'mark',        
        'exam_id',                       
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
    public function answers()
    {
        return $this->hasMany('Learning\Models\Learning\Answer','question_id');
    }
    public function getQuestionTypeAttribute()
    {
        switch ($this->attributes['question_type']) {
            case 'multiple_choice': return trans('learning::local.question_multiple_choice');
            case 'true_false': return trans('learning::local.question_true_false');
            case 'matching': return trans('learning::local.question_matching');
            case 'complete': return trans('learning::local.question_complete');                           
            case 'essay': return trans('learning::local.question_essay');                           
        }
    }
    public function matchings()
    {
        return $this->hasMany('Learning\Models\Learning\Matching','question_id');
    }
}
