<?php

namespace Staff\Models\Employees;

use Illuminate\Database\Eloquent\Model;
use Carbon;

class Attendance extends Model
{
    protected $fillable = [
        'attendance_id','status_attendance','time_attendance','admin_id'
    ];

    public function setTimeAttendanceAttribute($date) {
        $this->attributes['time_attendance'] = Carbon\Carbon::createFromFormat('d-m-Y H:i:s', $date);
    }

}
