<?php

namespace Staff\Http\Controllers\Employee;
use App\Http\Controllers\Controller;
use Staff\Models\Employees\Announcement;
use Carbon;
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
    public function account()
    {
        return view('staff::teacher.account');
    }
    public function password()
    {
        return view('staff::teacher.password');
    }
    public function dashboard()
    {
        $announcements = Announcement::where('domain_role','teacher')
        ->where('start_at','>=',\Carbon\Carbon::today())
        ->where('end_at','<=',\Carbon\Carbon::today())
        ->orderBy('id','desc')->limit(5)->get();
        return view('staff::teacher.teacher',
        compact('announcements'));
    }
}
