<?php

namespace Staff\Models\Employees;

use Illuminate\Database\Eloquent\Model;
use Carbon;

class Attendance extends Model
{
    protected $fillable = [
        'attendance_id','status_attendance','time_attendance','attendance_sheet_id','admin_id','mode'
    ];
    public function __construct(Array $attributes = [])
    {
        parent::__construct($attributes);
        
        $this->setConnection(session('connection')); // see config/database.php where you have specified this second connection to a different DB
    }
    public function setTimeAttendanceAttribute($date) {
        $this->attributes['time_attendance'] = Carbon\Carbon::createFromFormat('d-m-Y H:i:s', $date);
    }

    public function admin()
    {        
        return $this->belongsTo('App\Models\Admin','admin_id');
    }


}
