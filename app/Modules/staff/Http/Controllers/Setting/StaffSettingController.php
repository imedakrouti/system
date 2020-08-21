<?php

namespace Staff\Http\Controllers\Setting;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class StaffSettingController extends Controller
{
    public function index()
    {
        return view('staff::settings.settingPage',['title'=>trans('staff::admin.staff_setting')]);
    }
}
