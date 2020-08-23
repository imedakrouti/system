<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('layouts.backEnd.dashboards.dashboard',['title'=>trans('admin.dashboard')]);
    }
    public function admission()
    {
        /**
         * including all statistics for admissions and students
         */
        return view('student::dashboard._admission',['title'=>trans('admin.admissions')]);
    }
}
