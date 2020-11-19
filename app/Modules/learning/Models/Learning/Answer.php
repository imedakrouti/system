<?php

namespace Learning\Models\Learning;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = [
        'answer_text',
        'answer_note',
        'right_answer',        
        'question_id',                       
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
}
