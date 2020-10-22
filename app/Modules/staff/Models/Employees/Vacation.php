<?php

namespace Staff\Models\Employees;

use Illuminate\Database\Eloquent\Model;

class Vacation extends Model
{
    protected $fillable = [
        'date_vacation',
        'from_date',
        'to_date',
        'count',        
        'file_name',
        'approval1',
        'approval2',
        'vacation_type',
        'employee_id',
        'substitute_employee_id',
        'admin_id'
    ];
    public function admin()
    {
        return $this->belongsTo('App\Models\Admin','admin_id');
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
    public function getVacationTypeAttribute()
    {
        switch ($this->attributes['vacation_type']) {
            case 'Start work': return trans('staff::local.start_work');
            case 'End work': return trans('staff::local.end_work');
            case 'Sick leave': return trans('staff::local.sick_leave');
            case 'Regular vacation': return trans('staff::local.regular_vacation');
            case 'Vacation without pay': return trans('staff::local.vacation_without_pay');
            case 'Work errand': return trans('staff::local.work_errand');
            case 'Training': return trans('staff::local.training');
            case 'Casual vacation': return trans('staff::local.casual_vacation');
                                     
        }
    }
}
