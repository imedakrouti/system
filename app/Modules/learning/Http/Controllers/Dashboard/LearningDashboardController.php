<?php

namespace Learning\Http\Controllers\Dashboard;
use App\Http\Controllers\Controller;
class LearningDashboardController extends Controller
{
    public function dashboard()
    {
        $title = trans('admin.e_learning');

        return view('learning::dashboard.learning',      
        compact('title'));
    }

}
