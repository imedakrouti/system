<?php

namespace Staff\Models\Settings;

use Illuminate\Database\Eloquent\Model;

class Timetable extends Model
{
    protected $fillable = [
        'ar_timetable',
        'en_timetable',
        'description',
        'on_duty_time',
        'off_duty_time',
        'beginning_in',
        'ending_in',
        'beginning_out',
        'ending_out',
        'saturday',
        'sunday',
        'monday',
        'tuesday',
        'wednesday',
        'thursday',
        'friday',
        'saturday_value',
        'sunday_value',
        'monday_value',
        'tuesday_value',
        'wednesday_value',
        'thursday_value',
        'friday_value',
        'daily_late_minutes',
        'day_absent_value',
        'no_attend',
        'no_leave',
        'check_in_before_leave',
        'admin_id',    
    ];
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
