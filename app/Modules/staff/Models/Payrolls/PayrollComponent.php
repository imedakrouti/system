<?php

namespace Staff\Models\Payrolls;

use Illuminate\Database\Eloquent\Model;

class PayrollComponent extends Model
{
    protected $table = 'payroll_components';

    protected $fillable = [
        'period',
        'value',
        'from_date',
        'to_date',
        'salary_mode',
        'salary_bank_name',
        'salary_bank_account',
        'employee_id',
        'salary_component_id',
        'payroll_sheet_id',
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
    public function payrollSheet()
    {
        return $this->belongsTo('Staff\Models\Payrolls\PayrollSheet','payroll_sheet_id');
    }
}
