<?php

namespace Staff\Models\Employees;

use Illuminate\Database\Eloquent\Model;

class LeavePermission extends Model
{
    protected $table = 'leave_permissions';
    protected $fillable = [
        'date_leave',
        'time_leave',
        'approval_one_user',
        'approval_two_user',
        'approval1',
        'approval2',
        'leave_type_id',
        'employee_id',
        'admin_id',
         
    ];
    public function __construct(Array $attributes = [])
    {
        parent::__construct($attributes);
        
        $this->setConnection(session('connection')); // see config/database.php where you have specified this second connection to a different DB
    }
    public function admin()
    {
        return $this->belongsTo('App\Models\Admin','admin_id');
    }
    public function approvalOne()
    {
        return $this->belongsTo('App\Models\Admin','approval_one_user');
    }
    public function approvalTwo()
    {
        return $this->belongsTo('App\Models\Admin','approval_two_user');
    }
    public function employee()
    {
        return $this->belongsTo('Staff\Models\Employees\Employee','employee_id');
    }
    public function getApproval1Attribute()
    {
        switch ($this->attributes['approval1']) {
            case 'Accepted': return trans('staff::local.accepted');
            case 'Rejected': return trans('staff::local.rejected');
            case 'Canceled': return trans('staff::local.canceled');
            case 'Pending': return trans('staff::local.pending');                           
        }
    }

    public function getApproval2Attribute()
    {
        switch ($this->attributes['approval2']) {
            case 'Accepted': return trans('staff::local.accepted');
            case 'Rejected': return trans('staff::local.rejected');
            case 'Canceled': return trans('staff::local.canceled');
            case 'Pending': return trans('staff::local.pending');                           
        }
    }
    public function leaveType()
    {
        return $this->belongsTo('Staff\Models\Settings\LeaveType','leave_type_id');
    }
}
