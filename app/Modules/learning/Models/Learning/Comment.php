<?php

namespace Learning\Models\Learning;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [        
        'comment_text',                               
        'post_id',                       
        'user_id',                       
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
    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }
    public function post()
    {
        return $this->belongsTo('Learning\Models\Learning\Post','post_id');
    }
}
