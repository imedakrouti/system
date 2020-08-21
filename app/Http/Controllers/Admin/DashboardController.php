<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboards.dashboard',['title'=>trans('staff::admin.dashboard')]);
    }
    public function admission()
    {
        return view('dashboards.admission',['title'=>trans('admin.admissions')]);
    }
    public function staff()
    {
        return view('dashboards.staff',['title'=>trans('staff::admin.hr')]);
    }
}
