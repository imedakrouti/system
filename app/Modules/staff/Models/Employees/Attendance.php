<?php

namespace Staff\Models\Employees;

use Illuminate\Database\Eloquent\Model;
use Carbon;

class Attendance extends Model
{
    protected $fillable = [
        'attendance_id','status_attendance','time_attendance','attendance_sheet_id','admin_id','mode'
    ];

    public function setTimeAttendanceAttribute($date) {
        $this->attributes['time_attendance'] = Carbon\Carbon::createFromFormat('d-m-Y H:i:s', $date);
    }

    public function admin()
    {
        return $this->belongsTo(App\Models\Admin::class);
    }


}
