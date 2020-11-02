<?php

namespace Staff\Models\Employees;

use Illuminate\Database\Eloquent\Model;

class Deduction extends Model
{
    protected $fillable = [
        'date_deduction',
        'reason',
        'amount',
        'days',
        'approval1',      
        'approval2',          
        'employee_id', 
        'approval_one_user',
        'approval_two_user', 
        'leave_permission_id',        
        'admin_id'

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
}
