<?php
namespace Learning\Models\Learning;

use Illuminate\Database\Eloquent\Model;

class ZoomAccount extends Model
{
    protected $table = "zoom_accounts";

    protected $fillable = [        
        'employee_id',                
        'user_id',  
        'admin_id',  
        'meeting_id',    
        'pass_code'      
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

    public function admin()
    {
        return $this->belongsTo('App\Models\Admin','admin_id');
    }
}
