<?php

namespace Staff\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Staff\Models\Settings\LeaveType;

class TeacherController extends Controller
{
    public function permissions()
    {
        $leave_types = LeaveType::sort()->get();
        return view('staff::teacher.permissions', compact('leave_types'));
    }
    public function vacations()
    {
        return view('staff::teacher.vacations');
    }
    public function loans()
    {
        return view('staff::teacher.loans');
    }
    public function deductions()
    {
        return view('staff::teacher.deductions');
    }
    public function payrolls()
    {
        return view('staff::teacher.payrolls');
    }
    public function attendance()
    {
        return view('staff::teacher.attendance');
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
