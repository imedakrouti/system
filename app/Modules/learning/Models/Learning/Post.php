<?php

namespace Learning\Models\Learning;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [        
        'post_text',                               
        'youtube_url',                       
        'url',                       
        'file_name',                       
        'classroom_id',                       
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
    public function classroom()
    {
        return $this->belongsTo('Student\Models\Settings\Classroom','classroom_id');
    }
    public function comments()
    {
        return $this->hasMany('Learning\Models\Learning\Comment','post_id');
    }
}
