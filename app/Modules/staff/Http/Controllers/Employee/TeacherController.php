<?php

namespace Staff\Http\Controllers\Employee;

use App\Http\Controllers\Controller;


class TeacherController extends Controller
{

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
