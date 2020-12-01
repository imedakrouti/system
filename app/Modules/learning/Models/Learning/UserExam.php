<?php

namespace Learning\Models\Learning;

use Illuminate\Database\Eloquent\Model;

class UserExam extends Model
{
    protected $table = "user_exam";

    protected $fillable = [        
        'exam_id',                
        'user_id',  
        'report'      
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
