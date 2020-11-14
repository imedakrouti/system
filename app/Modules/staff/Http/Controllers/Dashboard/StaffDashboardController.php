<?php

namespace Staff\Http\Controllers\Dashboard;
use App\Http\Controllers\Controller;
class StaffDashboardController extends Controller
{
    public function dashboard()
    {
        $title = trans('admin.hr');

        return view('staff::dashboard.staff',      
        compact('title'));
    }

}
