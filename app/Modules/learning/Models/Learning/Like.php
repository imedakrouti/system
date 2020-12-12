<?php

namespace Learning\Models\Learning;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'post_id',
        'comment_id',
        'admin_id',
        'user_id',
        'like'
    ];


    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setConnection(session('connection')); // see config/database.php where you have specified this second connection to a different DB
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function admin()
    {
        return $this->belongsTo('App\Models\Admin', 'admin_id');
    }
        
}
