<?php

namespace Staff\Http\Controllers\Dashboard;
use App\Http\Controllers\Controller;
use Staff\Models\Employees\Announcement;

class StaffDashboardController extends Controller
{
    public function dashboard()
    {
        $title = trans('admin.hr');

        return view('staff::dashboard.staff',      
        compact('title'));
    }
    public function teacherDashboard()
    {
        $announcements = Announcement::where('domain_role','teacher')
        ->where('start_at','<=',\Carbon\Carbon::today())
        ->where('end_at','>=',\Carbon\Carbon::today())
        ->orderBy('id','desc')->limit(5)->get();
        return view('staff::dashboard.teacher',
        compact('announcements'));
    }

}
