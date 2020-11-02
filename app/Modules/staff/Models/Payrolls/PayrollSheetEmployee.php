<?php

namespace Staff\Models\Payrolls;

use Illuminate\Database\Eloquent\Model;

class PayrollSheetEmployee extends Model
{
    protected $table = "payroll_sheet_employees";

    protected $fillable = [
        'employee_id',
        'payroll_sheet_id',
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
}
