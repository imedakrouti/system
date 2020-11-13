<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Staff\Models\Employees\Employee;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $employees = Employee::work()->get();
        foreach ($employees as $employee) {
            Admin::firstOrCreate([
                'name'          => $employee->en_st_name,
                'ar_name'       => $employee->ar_st_name,
                'domain_role'   => 'teacher',
                'username'      => strtolower(str_replace(' ', '', trim($employee->en_st_name))).$employee->attendance_id,
                'email'         => $employee->email,
                'password'      => 'password'.$employee->attendance_id                
            ]);
        }
        
    }


}
