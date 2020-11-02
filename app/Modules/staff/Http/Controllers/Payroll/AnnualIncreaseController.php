<?php

namespace Staff\Http\Controllers\Payroll;
use App\Http\Controllers\Controller;
use Staff\Models\Employees\Employee;
use Staff\Models\Settings\Department;
use Staff\Models\Settings\Position;
use Staff\Models\Settings\Section;
use Staff\Models\Settings\Sector;

class AnnualIncreaseController extends Controller
{
    public function index()
    {
        $sectors = Sector::sort()->get();
        $departments = Department::sort()->get();
        $sections = Section::sort()->get();
        $positions = Position::sort()->get();
        $employees = Employee::work()->get();
        $title = trans('staff::local.annual_increase');
        return view('staff::payrolls.annual-increase.index',
        compact('sectors','departments','sections','positions','employees','title'));
    }
    public function updateSalaries()
    {
        $annual_increase = request('annual_increase');
        if (request('execute_type') == 'employees') {
            foreach (request('employee_id') as $employee_id) {
                $salary = Employee::findOrFail($employee_id)->salary;
                $annual_increase = ($salary * $annual_increase) / 100;
                $new_salary = $salary + $annual_increase;
                Employee::where('hiring_date','<=',request('set_date'))
                ->where('id',$employee_id)
                ->update(['salary'=>$new_salary]);
            }
        }else{
            foreach (request('department_id') as $department_id) {
                $employees = Employee::work()->where('department_id',$department_id)->get();
                foreach ($employees as $employee) {                
                    $salary = Employee::findOrFail($employee->id);
                    if (!empty($salary->hiring_date)) {
                        $annual_increase = ($salary->salary * $annual_increase) / 100;
                        
                        $new_salary = $salary->salary + $annual_increase;
                        Employee::where('hiring_date','<=',request('set_date'))
                        ->where('id',$employee->id)
                        ->where('department_id',$department_id)
                        ->update(['salary'=>$new_salary]);                                           
                    }
                }
            }
        }
        toast(trans('staff::local.set_annual_increase'),'success');
        return redirect()->route('annual-increase.index');
    }
}
