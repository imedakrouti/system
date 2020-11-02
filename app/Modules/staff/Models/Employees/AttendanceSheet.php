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
    public function __construct(Array $attributes = [])
    {
        parent::__construct($attributes);
        
        $this->setConnection(session('connection')); // see config/database.php where you have specified this second connection to a different DB
    }
    public function attendance()
    {
        return $this->belongsTo('Staff\Models\Employees\Attendance','attendance_id');
    }
}
