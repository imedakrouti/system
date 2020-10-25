<?php

namespace Staff\Models\Employees;

use Illuminate\Database\Eloquent\Model;

class AttendanceSheet extends Model
{
    protected $table = 'attendance_sheets';

    protected $fillable = ['sheet_name','admin_id'];

    public function admin()
    {        
        return $this->belongsTo('App\Models\Admin','admin_id');
    }
    
    public function attendance()
    {
        return $this->belongsTo('Staff\Models\Employees\Attendance','attendance_id');
    }
}
