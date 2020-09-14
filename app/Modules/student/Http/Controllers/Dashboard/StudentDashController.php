<?php

namespace Student\Http\Controllers\Dashboard;
use App\Http\Controllers\Controller;




class StudentDashController extends Controller
{
    public function dashboard()
    {                
        $title = trans('admin.students_affairs');

        return view('student::dashboard._students-affairs',      
        compact('title'));
    }

 
}
