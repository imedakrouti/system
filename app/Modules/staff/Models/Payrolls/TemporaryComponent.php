<?php

namespace Staff\Models\Payrolls;

use Illuminate\Database\Eloquent\Model;

class TemporaryComponent extends Model
{
    protected $table = 'temporary_components';

    protected $fillable = [
        'date',
        'remark',
        'amount',
        'employee_id',
        'salary_component_id',
        'admin_id',
    ];
    public function admin()
    {
        return $this->belongsTo('App\Models\Admin','admin_id');
    }
    public function employees()
    {
        return $this->belongsTo('Staff\Models\Employees\Employee','employee_id');
    }
    public function salaryComponents()
    {
        return $this->belongsTo('Staff\Models\Settings\SalaryComponent','salary_component_id');
    }
}
