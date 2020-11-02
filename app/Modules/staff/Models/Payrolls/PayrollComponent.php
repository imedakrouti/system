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
        'code',
        'calculate',
        'total_employees',
        'sort',
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
