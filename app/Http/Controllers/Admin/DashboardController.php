<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {        
        switch (authInfo()->domain_role) {
            case 'owner':
                # code...
                break;
            case 'super admin':
                # code...
                break;
            case 'super visor':
                # code...
                break;
            case 'manager':
                # code...
                break;
            case trans('staff::local.staff'):
                return view('layouts.backEnd.dashboards.dashboard',['title'=>trans('admin.dashboard')]);
                break;            
            default:
                return view('layouts.backEnd.dashboards.teacher',['title'=>trans('admin.dashboard')]);                
                break;
        }
    }

}
