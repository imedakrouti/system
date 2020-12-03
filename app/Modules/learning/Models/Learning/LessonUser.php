<?php

namespace Learning\Models\Learning;

use Illuminate\Database\Eloquent\Model;

class LessonUser extends Model
{
    protected $table = "lesson_user";

    protected $fillable = [        
        'lesson_id',                
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
}
