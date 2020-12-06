<?php

namespace Learning\Models\Learning;

use Illuminate\Database\Eloquent\Model;

class DeliverHomework extends Model
{
    protected $table = "deliver_homework";

    protected $fillable = [
        'user_answer',
        'mark',
        'remark',
        'file_name',
        'homework_id',
        'question_id',
        'user_id',
    ];
    public function __construct(Array $attributes = [])
    {
        parent::__construct($attributes);
        
        $this->setConnection(session('connection')); // see config/database.php where you have specified this second connection to a different DB
    }
    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }
    public function question()
    {
        return $this->belongsTo('Learning\Models\Learning\Question','question_id');
    }
    public function homework()
    {
        return $this->belongsTo('Learning\Models\Learning\Homework','homework_id');
    }
}
