<?php

namespace Staff\Models\Settings;

use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
    protected $fillable = ['device_name','ip_address','port','admin_id'];
    public function __construct(Array $attributes = [])
    {
        parent::__construct($attributes);
        
        $this->setConnection(session('connection')); // see config/database.php where you have specified this second connection to a different DB
    }
    public function admins()
    {
        $this->belongsTo(App\Models\Admin::class);
    }
}
