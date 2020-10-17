<?php

namespace Staff\Models\Settings;

use Illuminate\Database\Eloquent\Model;

class HolidayDay extends Model
{
    protected $table = "holiday_days";
    protected $fillable = ['date_holiday','description','holiday_id','admin_id'];
    
    public function admins()
    {
        $this->belongsTo(App\Models\Admin::class);
    }
    public function holiday()
    {
        return $this->belongsTo(Holiday::class);        
    }
}
