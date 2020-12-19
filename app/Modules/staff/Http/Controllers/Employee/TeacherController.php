<?php

namespace Staff\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Staff\Models\Employees\Employee;

class TeacherController extends Controller
{

    public function attendance()
    {
        $employees = Employee::where('direct_manager_id', employee_id())->work()->get();
        return view(
            'staff::teacher.attendance',
            compact('employees')
        );
    }

    public function account()
    {
        return view('staff::teacher.account');
    }

    public function password()
    {
        return view('staff::teacher.password');
    }
}
