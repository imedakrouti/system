<?php

namespace Learning\Models\Learning;

use Illuminate\Database\Eloquent\Model;

class ZoomSchedule extends Model
{
    protected $table = "zoom_schedules";

    protected $fillable = [        
        'topic',                
        'start_date',  
        'admin_id',  
        'start_time',    
        'classroom_id',           
        'notes'      
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
}
