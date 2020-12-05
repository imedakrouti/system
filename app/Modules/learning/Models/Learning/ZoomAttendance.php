<?php

namespace Learning\Models\Learning;

use Illuminate\Database\Eloquent\Model;

class ZoomAttendance extends Model
{
    protected $table = "zoom_attendances";

    protected $fillable = [        
        'zoom_schedule_id',                
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
}
