<?php

namespace Staff\Models\Payrolls;

use Illuminate\Database\Eloquent\Model;

class FixedComponent extends Model
{
    protected $table = 'fixed_components';

    protected $fillable = [        
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
