<?php

namespace Staff\Models\Settings;

use Illuminate\Database\Eloquent\Model;

class HolidayDay extends Model
{
    protected $table = "holiday_days";
    protected $fillable = ['date_holiday','description','holiday_id','admin_id'];
    public function __construct(Array $attributes = [])
    {
        parent::__construct($attributes);
        
        $this->setConnection(session('connection')); // see config/database.php where you have specified this second connection to a different DB
    }
    public function admins()
    {
        $this->belongsTo(App\Models\Admin::class);
    }
    public function holiday()
    {
        return $this->belongsTo(Holiday::class);        
    }
}
