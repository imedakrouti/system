<?php

namespace Staff\Http\Controllers\Employee;
use App\Http\Controllers\Controller;

class TeacherController extends Controller
{
    public function permissions()
    {
        return view('staff::teacher.permissions');
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
}
